1. htdocs in das Webverzeichnis legen
2. config.inc.php im Ordner inc bearbeiten (MSSQL Daten)
4. Datenbank WEBSITE_DBF in MSSQL erstellen und danach beigelegte WEBSITE_DBF.sql ausführen
5. In ACCOUNT_DBF -> ACCOUNT_TBL folgende Spalte adden:
- votepoints (Typ: int)

- neue News hinzufügen: 
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_news öffnen
	- title adden (zb. Patchlogs, Event usw) 
	- Text um Text mit absätzen einzufügen folgendes beachten 
		-Nach dem Zeilen ende <br> einfügen (Zeilenumbruch)
	- category "nid" von dbo.web_newscategories eingeben (zb. 2 (news))
	- author - Wer den Text geschrieben hat 
	- datetime : Datum und Uhrzeit wann der Text geschrieben wurde
	
- neue News category hinzufügen:
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_newscategories öffnen
	- title = Name der category
	- icon = Name der Icon datei welches gezeigt werden soll (Icon muss sich im "../htdocs/img" befinden)
		- Größe sollte 82x18 px betragen

- neue Downloads hinzufügen:
	- Microfsoft Server SQL Managment in folgender DB: WEBSITE_DBF/Tables dbo.web_downloads öffnen
	- title = Name der Download datei z.B. "Madness Flyff" 
	- description = Beschreibung der Download Datei z.B. "Full Client"
	- link = Link vom Download 
	- datetime = Datum und Uhrzeit der Veröffentlichung
	
- neue FAQ's hinzufügen: 
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_faq öffnen
	- question - Frage, wird als "Fetter" Text ausgegeben
	- answer - Antwort, beachten wie der Text geschrieben wird (z.B. mit "<br>" als Zeilenumbruch)
	
- neue Shop Items hinzufügen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_mall öffnen
	- itemid = Flyff Item Id aus der defineItem.h einfügen 
	- Name = Item Name eingeben z.B. "Perin"
	- description = Beschreibung des Items eingeben z.B. "Hierduch bekommst du 100.000.000 Penya"
	- price = Preis des Items z.B. 10DP(= 10€) 
	- count = Menge der Items, welche man nach kauf erhält z.B. (count 10 = 10 Perin)
	- category "mcatid" aus dbo.mallcategories einfügen
	- icon = Name der Icon Datei, welches gezeigt werden soll (Icon muss sich im "..htdocs\img\mall" befinden)
	
- neue Shop category hinzufügen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_mallcategroies öffnen
	- "category" Namen der category eingeben 
	
- vote Item hinzufügen:
	- Microfsoft Server SQL Managment in folgender DB WEBSITE_DBF/Tables dbo.web_voteitem öffnen
	- itemid = Item Id aus der defineItem.h einfügen	
	- Name = Namen des Items z.B. "Perin"
	- count = gibt an wie viele Items man pro kauf bekommt 
	- price = gibt den Preis des Items an (z.B. price 1 = Preis 1 Vote Punkt)
	- icon = Name der Icon Datei, welches gezeigt werden soll (Icon muss sich im "../htdocs/img" befinden)
	
- Recaptcha für z.B. Kommentare schreiben unter Patchlogs 
	- Registriert euch bei https://www.google.com/recaptcha und erstellt euch einen API-Schlüssel
	- Fügt den Recaptcha Site Key im Code ein (guck nach // Hier fügst du deinen reCAPTCHA-Key ein )