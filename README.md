# Projektapi DT173G
Detta är en webbtjänst till ett projekt i kursen DT173G. Denna webbtjänst används av en front-end sida samt ett admingränssnitt för att visa och hantera data.
I detta fall är syftet att presentera och kunna hantera en portfolio.

## Uppbyggnad av API

- **/config/classes**
  - **[namn].class.php:** Det finns tre stycken filer med tre olika klasser, dessa används för att inom databasen hämta, lagra, ändra samt ta bort.

- **/config**
  - **config.php:** Denna fil innehåller autoload för snabbare inläsning av klasser.
  - **Database.php:** Denna fil innehåller en klass för att ansluta till databasen.

- **root**
  - **[namn].php:** I root ligger tre ytterligare .php filer, dessa konsumerar webbtjänsten och består av en switch med cases för alla olika request typer.

## I detta projekt används följande requests
- GET för att hämta från databasen
- POST för att skicka till databasen
- PUT för att uppdatera angivet ID i databasen
- DELETE för att ta bort angivet ID i databasen

## För att klona detta repo skriver du följande i din terminal
`git clone https://github.com/jespernorris/projektapi_dt173g.git`
