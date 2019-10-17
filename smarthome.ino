#include <PubSubClient.h>
#include <ESP8266WiFi.h>
#include <WiFiClientSecure.h>
#include <UniversalTelegramBot.h>

const char* ssid = "ssid_wifi";
const char* password = "password_wifi";
const char* mqtt_server = "ip_public_mqtt";

// Initialize Telegram BOT
#define BOTtoken "telegram_bot_token"

WiFiClient espClient;
PubSubClient client(espClient);

WiFiClientSecure client_bot;
UniversalTelegramBot bot(BOTtoken, client_bot);

int Bot_mtbs = 1000; //mean time between scan message
long Bot_lasttime; //last time messages scan has been done

long lastMsg = 0;
char msg[50];
char msgled[50];
char msgsensor[50];

// lampu
int value = 0;
int ledPin = D5; //
int ledValue;
char ledStat[10] = "ledStatus";
char* SledValue;

// intensitas lampu
//int sensorPin = A0;
//int sensorValue;
//char sensorValueSend[50];

//sensor suhu
int analogVal = 0;
float mVolt = 0;
float celcius = 0;
char sensorValueSend[50];

int fanPin = D6;
int fanValue;




void handleNewMessages(int numNewMessages){
  Serial.println("handleNewMessages");
  Serial.println(String(numNewMessages));

  analogVal = analogRead(A0);
  mVolt = (analogVal / 1024.0) * 3300;
  celcius = mVolt / 10;

  String suhu;
  suhu = String(celcius);
  suhu.toCharArray(sensorValueSend,1000);

  //sensor lampu
  //sensorValue = analogRead(A0);

  for(int i=0; i<numNewMessages; i++){
    String chat_id = String(bot.messages[i].chat_id);
    String text = bot.messages[i].text;

    String from_name = bot.messages[i].from_name;
    if (from_name == "") from_name = "Guest";

    if (text != "/lampu" && text != "hi bot" && text != "/suhu" && text != "/google") {
      String salah = "gak ngerti perintah lo. pilih perintah dibawah ini.\n\n";
      salah += "hi bot : untuk perintah gue";
      bot.sendMessage(chat_id, salah, "Markdown");
    }

    if (text == "/suhu"){
      String keterangan = "Suhu dirumah sekarang " + suhu + " Celcius";
      bot.sendMessage(chat_id, keterangan, "Markdown");
    }
    
    if (text == "/google") {
      String keyboardJson = "[[\{ \"text\" : \"Go to Google\", \"url\" : \"https://www.google.com\" \} ]]";
      bot.sendMessageWithInlineKeyboard(chat_id, "Choose from one of the following options", "", keyboardJson);       
    }

    // sensor lampu
//    if (text == "/lampu"){
//      if (sensorValue > 500){
//        String keterangan = "Hai bos lampu dirumah lagi mati";
//        
//        bot.sendMessage(chat_id, keterangan, "Markdown");
//      } else {
//        String keterangan = "Hai jomblo lampu dirumah lagi nyala";
//        bot.sendMessage(chat_id, keterangan, "Markdown");
//      }
//    }

    if (text == "hi bot") {
      String welcome = "Hi , " + from_name + ".\n";
      welcome += "Nama saya jarvis, saya asisten anda .\n\n";
      welcome += "/google : untuk ke google\n";
      welcome += "/suhu : untuk menanyakan status suhu\n";
      welcome += "/lampu : untuk menanyakan status lampu sekarang\n";

      bot.sendMessage(chat_id, welcome, "Markdown");
    }
  }
}

void callback(char* topic, byte* payload, unsigned int length){
  Serial.print("Message arrived[");
  Serial.print(topic);
  Serial.print("] ");

  for (int i = 0; i < length; i++){
    Serial.print((char)payload[i]);
  }
  Serial.println();

  // Switch on the L3 if topic is ledStat and 1 was received as first character
  if ((strcmp (topic, ledStat) == 0) && ((char)payload[0] == '1')) {
    digitalWrite(ledPin, LOW);
    client.publish("ledState", "LED ON");
  }

  // Switch off the L3 if topic is ledStat and 0 was received as first character
  if ((strcmp (topic, ledStat) == 0) && ((char)payload[0] == '0')) {
    digitalWrite(ledPin, HIGH);
    client.publish("ledState", "LED OFF");
  }
}

void checkLed() {
  ledValue = digitalRead(ledPin); // read led pin value
  if (ledValue == 0){
    SledValue = "LED ON";
  } else {
    SledValue = "LED OFF";
  }
}

//sensor lampu
//void sensor(){
//  sensorValue = analogRead(sensorPin);
//  
//  String str;
//  str = String(sensorValue);
//  str.toCharArray(sensorValueSend,1000);
//}

// sensor suhu
void sensor(){
  analogVal = analogRead(A0);
  mVolt = (analogVal / 1024.0) * 3300;
  celcius = mVolt / 10;
  
  String str;
  str = String(celcius);
  str.toCharArray(sensorValueSend,1000);
}


boolean reconnect(){
  //Loop until were reconnected
  while (!client.connected()){
    Serial.print("Attempting MQTT connection...");

    //Attempt to connect
    
    // edit yoseph
    
    if (client.connect("ESP8266Client","deviceState",1,false,"OFFLINE")){
      
      //end yoseph
      Serial.println("connected");
      //once connected, publish an announcement
      checkLed();
      sensor();
      client.publish("sensorStat", sensorValueSend);
      client.publish("ledStatus2", SledValue);
      // ... and subscribe to topic
      client.subscribe("ledStatus");
      client.subscribe("fanStatus");
      client.publish("deviceState", "ONLINE");
      return client.connected();
    } else {
      Serial.print("failed, rc=");
      Serial.print(client.state());
      Serial.println("try again in 5 seconds");
      // Wait 5 seconds before retrying
      delay(5000);
    }
  }
}

void setup() {
  Serial.begin(115200);
  client.setServer(mqtt_server, 1883);
  client.setCallback(callback);
  pinMode(ledPin, OUTPUT);
  pinMode(fanPin, OUTPUT);
  digitalWrite(ledPin, HIGH);
  
   // Connect to WiFi
  WiFi.begin(ssid, password);
  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.println("WiFi connected");
  Serial.print("IP address: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  if (!client.connected()) {
    reconnect();
  }
  
  if (millis() > Bot_lasttime + Bot_mtbs){
    int numNewMessages = bot.getUpdates(bot.last_message_received + 1);

    while(numNewMessages){
      Serial.println("got response");
      handleNewMessages(numNewMessages);
      numNewMessages = bot.getUpdates(bot.last_message_received + 1);
    }

    Bot_lasttime = millis();
  }
  
  client.loop();
  long now = millis();
  if (now - lastMsg > 1000) {
    lastMsg = now;
    ++value;
    snprintf (msg, 75, "ONLINE", value);
    Serial.println(msg);
    client.publish("deviceState", msg);

    snprintf (msgled, 75, SledValue, value);
    Serial.println(msgled);
    client.publish("ledStatus2", msgled);

    snprintf (msgsensor, 75, sensorValueSend, value);
    Serial.println(msgsensor);
    client.publish("sensorStat", msgsensor);
  }
  sensor();
  checkLed();
}
