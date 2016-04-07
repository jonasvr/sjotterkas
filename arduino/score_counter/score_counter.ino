// include the library code:
#include <LiquidCrystal.h>
#include <EEPROM.h>

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);

// constants won't change. They're used here to
// set pin numbers:
const int addLeft  = 22;     // the number of the pushbutton pin for add black
const int subLeft  = 24;     // the number of the pushbutton pin for cancel black
const int addRight  = 26;     // the number of the pushbutton pin for add green
const int subRight  = 28;     // the number of the pushbutton pin for cancel green
const int reset     = 30;     // the number of the pushbutton pin for reset
const int regi      = 32;     // the number of the pushbutton pin for registering a new player
// variables will change:
int addLeftState = 0;         // variable for reading the pushbutton status
int subLeftState = 0;         // variable for reading the pushbutton status
int addRightState = 0;         // variable for reading the pushbutton status
int subRightState = 0;         // variable for reading the pushbutton status
int resetState    = 0;         // variable for reading the pushbutton status to reset game
int regiState     = 0;         // variable for reading the pushbutton status registering a new player


int addLeftAdress = 0; //eeprom adress om op te slaan
int subLeftAdress = 1; //eeprom adress om op te slaan
int addRightAdress = 2; //eeprom adress om op te slaan
int subRightAdress = 3; //eeprom adress om op te slaan
int resetAdress    = 4; //eeprom adress om op te slaan
int regiAdress     = 7; //eeprom adress om op te slaan => adress 5 can't save 0 for some reason

int score[] = {0, 0}; //pos0 = team black - pos1 = team green

void setup() {
  Serial.begin(9600);
  // set up the LCD's number of columns and rows:
  lcd.begin(16, 2);
  // Print a message to the LCD.
  lcd.print("score board: ");
  // initialize the pushbutton pin as an input:
  pinMode(addLeft, INPUT_PULLUP);
  pinMode(subLeft, INPUT_PULLUP);
  pinMode(addRight, INPUT_PULLUP);
  pinMode(subRight, INPUT_PULLUP);
  pinMode(reset, INPUT_PULLUP);
  pinMode(regi, INPUT_PULLUP);
  printscore();
}

void loop() {
  checkButtons();
}

void checkButtons()
{
  //statussen van de buttons checken
  addLeftState = digitalRead(addLeft);  // read the input add
  subLeftState = digitalRead(subLeft);  // read the input sub
  addRightState = digitalRead(addRight);  // read the input add
  subRightState = digitalRead(subRight);  // read the input sub
  resetState = digitalRead(reset);  // read the input sub
  regiState = digitalRead(regi);  // read the input sub

  //checking the black
  //is added or sub pushed  
  if (addLeftState == LOW) {
    if (addLeftState != EEPROM.read(addLeftAdress))
    {
      EEPROM.write(addLeftAdress, addLeftState);
      updateScore("goal", 0);
      Serial.println("goal left");
    }
} else if (subLeftState == LOW) {
    if (subLeftState != EEPROM.read(subLeftAdress) && score[0] > 0)
    {
      EEPROM.write(subLeftAdress, subLeftState);
      updateScore("cancel", 0);
      Serial.println("cancel left");
    }
  }
  
  //checking the green
  //is added or sub pushed   
  else if (addRightState == LOW) {
    if (addRightState != EEPROM.read(addRightAdress))
    {
      EEPROM.write(addRightAdress, addRightState);
      updateScore("goal", 1);
      Serial.println("goal right");
    }
} else if (subRightState == LOW) {
    if (subRightState != EEPROM.read(subRightAdress) && score[1] > 0)
    {
      EEPROM.write(subRightAdress, subRightState);
      updateScore("cancel", 1);
      Serial.println("cancel right");
    }
  }
  else if (regiState == LOW) {
    if (regiState != EEPROM.read(regiAdress))
    {
      EEPROM.write(regiAdress, regiState);
      Serial.println("player");
    }
  }
  //checking if new game should be started
  else if (resetState == LOW) {
    if (resetState != EEPROM.read(resetAdress))
    {
      EEPROM.write(resetAdress, resetState);
      resetScore();
    }
  }
  else
  {
    EEPROM.write(subLeftAdress, subLeftState);
    EEPROM.write(addLeftAdress, addLeftState);
    EEPROM.write(subRightAdress, subRightState);
    EEPROM.write(addRightAdress, addRightState);
    EEPROM.write(resetAdress, resetState);
    EEPROM.write(regiAdress, regiState);
  }
}

void updateScore(String state, int team)
{
  //detect whitch team made an action
  lcd.clear();
  lcd.setCursor(0, 0);
  if (team == 0)
  {
    lcd.print("black");
  } else
  {
    lcd.print("green");
  }

  //detect what action
  lcd.setCursor(0, 1);
  if (state == "goal") {
    lcd.print("scores!!!");
    score[team]++;
  }
  else if (state == "cancel")
  {
    lcd.print("cancels");
    score[team]--;
  }

  delay(1000);
  printscore();
}

void printscore()
{
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("green");
  lcd.setCursor(6, 0);
  lcd.print(score[1]);

  lcd.setCursor(0, 1);
  lcd.print("black");
  lcd.setCursor(6, 1);
  lcd.print(score[0]);
}

void resetScore()
{
  //score op 0 zetten
  score[0] = 0;
  score[1] = 0;
  //melding geven
  lcd.clear();
  lcd.setCursor(0, 0);
  lcd.print("New Game!!");
  Serial.println("new");
  delay(1500);
  //scores op het scherm tonen
  printscore();
}
