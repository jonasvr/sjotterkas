// include the library code:
#include <LiquidCrystal.h>
#include <EEPROM.h>

// initialize the library with the numbers of the interface pins
LiquidCrystal lcd(12, 11, 5, 4, 3, 2);

// constants won't change. They're used here to
// set pin numbers:
const int addBlack  = 22;     // the number of the pushbutton pin for add black
const int subBlack  = 24;     // the number of the pushbutton pin for cancel black
const int addGreen  = 26;     // the number of the pushbutton pin for add green
const int subGreen  = 28;     // the number of the pushbutton pin for cancel green
const int reset     = 30;     // the number of the pushbutton pin for reset
const int regi      = 32;     // the number of the pushbutton pin for registering a new player
// variables will change:
int addBlackState = 0;         // variable for reading the pushbutton status
int subBlackState = 0;         // variable for reading the pushbutton status
int addGreenState = 0;         // variable for reading the pushbutton status
int subGreenState = 0;         // variable for reading the pushbutton status
int resetState    = 0;         // variable for reading the pushbutton status to reset game
int regiState     = 0;         // variable for reading the pushbutton status registering a new player


int addBlackAdress = 0; //eeprom adress om op te slaan
int subBlackAdress = 1; //eeprom adress om op te slaan
int addGreenAdress = 2; //eeprom adress om op te slaan
int subGreenAdress = 3; //eeprom adress om op te slaan
int resetAdress    = 4; //eeprom adress om op te slaan
int regiAdress     = 5; //eeprom adress om op te slaan

int score[] = {0, 0}; //pos0 = team black - pos1 = team green

void setup() {
  Serial.begin(9600);
  // set up the LCD's number of columns and rows:
  lcd.begin(16, 2);
  // Print a message to the LCD.
  lcd.print("score board: ");
  // initialize the pushbutton pin as an input:
  pinMode(addBlack, INPUT_PULLUP);
  pinMode(subBlack, INPUT_PULLUP);
  pinMode(addGreen, INPUT_PULLUP);
  pinMode(subGreen, INPUT_PULLUP);
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
  addBlackState = digitalRead(addBlack);  // read the input add
  subBlackState = digitalRead(subBlack);  // read the input sub
  addGreenState = digitalRead(addGreen);  // read the input add
  subGreenState = digitalRead(subGreen);  // read the input sub
  resetState = digitalRead(reset);  // read the input sub
  regiState = digitalRead(regi);  // read the input sub

  //checking the black
  //is added or sub pushed  
  if (addBlackState == LOW) {
    if (addBlackState != EEPROM.read(addBlackAdress))
    {
      EEPROM.write(addBlackAdress, addBlackState);
      updateScore("goal", 0);
      Serial.println("goal black");
    }
  } else if (subBlackState == LOW) {
    if (subBlackState != EEPROM.read(subBlackAdress) && score[0] > 0)
    {
      EEPROM.write(subBlackAdress, subBlackState);
      updateScore("cancel", 0);
      Serial.println("cancel black");
    }
  }
  
  //checking the green
  //is added or sub pushed   
  else if (addGreenState == LOW) {
    if (addGreenState != EEPROM.read(addGreenAdress))
    {
      EEPROM.write(addGreenAdress, addGreenState);
      updateScore("goal", 1);
      Serial.println("goal green");
    }
  } else if (subGreenState == LOW) {
    if (subGreenState != EEPROM.read(subGreenAdress) && score[1] > 0)
    {
      EEPROM.write(subGreenAdress, subGreenState);
      updateScore("cancel", 1);
      Serial.println("cancel green");
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
    EEPROM.write(subBlackAdress, subBlackState);
    EEPROM.write(addBlackAdress, addBlackState);
    EEPROM.write(subGreenAdress, subGreenState);
    EEPROM.write(addGreenAdress, addGreenState);
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
