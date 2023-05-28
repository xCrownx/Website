1. htdocs in das Webverzeichnis legen
2. config.inc.php im Ordner inc bearbeiten (MSSQL Daten)
4. Datenbank WEBSITE_DBF in MSSQL erstellen und danach beigelegte WEBSITE_DBF.sql ausf�hren
5. In ACCOUNT_DBF -> ACCOUNT_TBL folgende Spalte adden:
- votepoints (Typ: int)

- neue News hinzuf�gen: 
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_news �ffnen
	- title adden (zb. Patchlogs, Event usw) 
	- Text um Text mit abs�tzen einzuf�gen folgendes beachten 
		-Nach dem Zeilen ende <br> einf�gen (Zeilenumbruch)
	- category "nid" von dbo.web_newscategories eingeben (zb. 2 (news))
	- author - Wer den Text geschrieben hat 
	- datetime : Datum und Uhrzeit wann der Text geschrieben wurde
	
- neue News category hinzuf�gen:
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_newscategories �ffnen
	- title = Name der category
	- icon = Name der Icon datei welches gezeigt werden soll (Icon muss sich im "../htdocs/img" befinden)
		- Gr��e sollte 82x18 px betragen

- neue Downloads hinzuf�gen:
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_downloads �ffnen
	- title = Name der Download datei z.B. "Madness Flyff" 
	- description = Beschreibung der Download Datei z.B. "Full Client"
	- link = Link vom Download 
	- datetime = Datum und Uhrzeit der Ver�ffentlichung
	
- neue FAQ's hinzuf�gen: 
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_faq �ffnen
	- question - Frage, wird als "Fetter" Text ausgegeben
	- answer - Antwort, beachten wie der Text geschrieben wird (z.B. mit "<br>" als Zeilenumbruch)
	
- neue Shop Items hinzuf�gen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_mall �ffnen
	- itemid = Flyff Item Id aus der defineItem.h einf�gen 
	- Name = Item Name eingeben z.B. "Perin"
	- description = Beschreibung des Items eingeben z.B. "Hierduch bekommst du 100.000.000 Penya"
	- price = Preis des Items z.B. 10DP(= 10�) 
	- count = Menge der Items, welche man nach kauf erh�lt z.B. (count 10 = 10 Perin)
	- category "mcatid" aus dbo.mallcategories einf�gen
	- icon = Name der Icon Datei, welches gezeigt werden soll (Icon muss sich im "..htdocs\img\mall" befinden)
	
- neue Shop category hinzuf�gen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_mallcategroies �ffnen
	- "category" Namen der category eingeben 
	
- vote Item hinzuf�gen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_voteitem �ffnen
	- itemid = Item Id aus der defineItem.h einf�gen	
	- Name = Namen des Items z.B. "Perin"
	- count = gibt an wie viele Items man pro kauf bekommt 
	- price = gibt den Preis des Items an (z.B. price 1 = Preis 1 Vote Punkt)
	- icon = Name der Icon Datei, welches gezeigt werden soll (Icon muss sich im "../htdocs/img" befinden)
	
- Recaptcha f�r z.B. Kommentare schreiben unter Patchlogs 
	- Registriert euch bei https://www.google.com/recaptcha und erstellt euch einen API-Schl�ssel
	- F�gt den Recaptcha Site Key im Code ein (guck nach // Hier f�gst du deinen reCAPTCHA-Key ein )