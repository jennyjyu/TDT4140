# Nigiri falls - takeout application

An Android application ordered by the sushi restaurant Nigiri Falls to enable takeout from the restaurant. The application will be used by costumers to place orders from the restaurants three locations in Oslo, Trondheim and Bergen, and by the employees to review and edit orders.

## Get started

### Running the application

The application can be run on an Android emulator or on an Android phone with API 26 or higher. To run the application go through the following steps:

### Install Android studio

At the moment, the only way to run the application is through Android studio. Download Android studio here: https://developer.android.com/studio/ and install it.

### Import repository from GitLab using HTTPS
(Can also use SSH key method so you don't need to type password all the time)

1. Copy: `https://gitlab.stud.idi.ntnu.no/programvareutvikling-v19/gruppe-50.git`

2. In Android Studio: File>New>Project from Version Control>Git
a
3. Paste GitLab URL

4. Test

5. Choose directory you want the project in

6. Clone

**Now you should see the project files from GitLab in Android Studio**
### Add necessary file to your repository

*  Create a new file called `local.properties` **Not in a subfolder, just next to README.md etc.** 
*  Addt this line to it `sdk.dir=/home/USER/Android/Sdk` with USER being your PC username 

### Running the application

The application can be run on an Android emulator or on an Android phone with API level 16  or higher, but the recommended API level is 28, which means Android version 9. To run the application go through the following steps:

#### Run application in emulator or on Android device

Click on run and when you get to the select target screen, either set up an emulator or connect an Android device both with API level 16 or higher (recommended is 28). Run the application on your target of choice and the application should be running.


### How to use git with Android Studio 

We recommend using Android Studios integrated terminal when using git. You find this terminal at the bottom left of the Android Studio program. Next to **TODO** and **Version Control**. Click **Terminal**

## Get access to database at PhpMyAdmin
Login to the database at https://mysqladmin.stud.ntnu.no
* Usernames: magnuti_super, magnuti_super1, magnuti_super2
* Password for every user: nigiri50

## Built with

* Android Studio - Android development environment
* SQL - Database management
* PHP - REST Web API


## Authored by

* Magnus Tideman
* Jenny Yu
* Theodor Lopez Holmsen
* Ingrid Fotland Aaseng
* Petter Hoem Sletsjøe
* Johan Nicolaisen Brun

## Thanks to

Sabrura for inspiration and sushi names/descriptions.










