const int switchPin = A2; // The digital pin to which the switch is connected
int switchState = 0; // Variable to store the current state of the switch
int lastSwitchState = 0; // Variable to store the previous state of the switch
const int pingPin = 13;
int inPin = 12;
int count = 0;
float cm1 ,cm2 ,cm3 ,result_cm ,result_m;

void setup() {
pinMode(switchPin, INPUT); // Set the switch pin as an input
Serial.begin(9600); // Initialize serial communication for debugging
Serial.print("------------- Ready ---------------------\n");
}

void loop() {
long duration, cm;

pinMode(pingPin, OUTPUT);


// Read the current state of the switch
switchState = digitalRead(switchPin);

if (switchState == LOW) {
// Serial.println("Switch pressed!");
count++;

digitalWrite(pingPin, LOW);
delayMicroseconds(2);
digitalWrite(pingPin, HIGH);
delayMicroseconds(5);
digitalWrite(pingPin, LOW);
pinMode(inPin, INPUT);
duration = pulseIn(inPin, HIGH);
// Add your code here to perform an action when the switch is pressed
if(count==1){


cm1 = microsecondsToCentimeters(duration);

Serial.print("กว้าง = ");
Serial.print(cm1);
Serial.println();
delay(100);

}
if(count==2){


cm2 = microsecondsToCentimeters(duration);

Serial.print("ยาว = ");
Serial.print(cm2);
Serial.println();
delay(100);

}
if(count==3){


cm3 = microsecondsToCentimeters(duration);


Serial.print("สูง = ");
Serial.print(cm3);
Serial.println();
delay(100);

result_cm = (cm1*cm2*cm3);
result_m = result_cm/10;
Serial.print("------------- Answer ---------------------\n");
Serial.print("ปริมาตรเท่ากับ = ");
Serial.print(result_m);
Serial.print(" x 10^5 m3");
Serial.println();

// Find the minimum value
float min_value = min(min(cm1, cm2), cm3);

// Find the maximum value
float max_value = max(max(cm1, cm2), cm3);

// Print the results
Serial.print("------------- Max - Min ---------------------\n");
Serial.print("ค่าน้อยสุด : ");
Serial.println(min_value);
Serial.print("ค้ามากสุด : ");
Serial.println(max_value);

// Print the results
Serial.print("------------- m3 ---------------------\n");
result_m = result_cm/1000000;
result_m = 1/result_m;

Serial.print("ต้องใช้ : ");
Serial.print(result_m);
Serial.print(" หน่วย - จะได้ใกล้เคียง 1 ลูกบากศ์เมตร");git checkout 51-all-page-update-edit-page-config
Serial.println();

}
if(count==4){
Serial.print("------------- Reset ---------------------");
Serial.println();
delay(100);
count=0;
}

}
// Update the last switch state
lastSwitchState = switchState;
}

// You can add other code here that runs continuously
// ...
}

long microsecondsToCentimeters(long microseconds)
{
// The speed of sound is 340 m/s or 29 microseconds per centimeter.
// The ping travels out and back, so to find the distance of the
// object we take half of the distance travelled.
return microseconds / 29 / 2;
}