# Fitness App - Database

Um den WebServer und die Datenbank nutzen zu können, brauch man XAMPP und mindestens die PHP-Version 8.0.0.
Damit die WebSeite aufgerufen werden kann, reicht es den ganzen Inhalt in den `htdocs` Ordner von XAMPP zu verschieben.
Bevor aber der WebServer gestartet werden kann, muss die Datenbank aufgesetzt werden.
Dafür startet man in XAMPP den MySQL Server. Sobald man sich mit der Datenbank verbunden hat, muss 
die Datenbank noch aufgesetzt werden. Dafür reicht es die Befehle in der Datei `MySQL_Commands.sql`
von oben nach unten auszuführen. Dabei werden auch einige standard Werte
eingefügt. Danach kann in XAMPP noch der WebServer bzw. Apache gestartet werden.
Jetzt sollte die Webseite über [http://localhost](http://localhost:80)
erreichbar sein. 

Login Daten findet man ebenfalls in der `MySQL_Commands.sql` Datei.