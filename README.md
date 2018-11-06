# Docker workshop

* Haal een VM op
* Verbind met SSH colablik@*.cloudzuid.nl
* Het wachtwoord staat op je papiertje.
* Docker is toegevoegd aan je groep. Je hoeft dus niet te `sudo docker`'en.

Ben je geen command line held en is vim eng?

![shame](https://i.imgur.com/hyI9ItE.gif "shame")

Je kunt ook ssh://JE-VM-NUMMER.cloudzuid.nl met colablik en je wachtwoord invullen in je file browser. Dan wordt ie lokaal gemount via SSH. Maar je ontkomt vandaag niet aan je command line.

# Basic Cheats

## General
```docker run``` Run a container

```docker run -it --rm -v $(pwd):/app:ro -p 80:80 --net barry alpine /bin/ash``` Run a throwaway interactive 'alpine' container with current directory readonly mounted as `/app`, listening on port 80 in network barry with `/bin/ash` (not a bash typo)

```docker exec``` Execute something in a running container

```docker help run``` Learn how to run a container

```docker help *``` Learn how to * with Docker

```docker``` See everything Docker can do for you

## Containers
```docker ps``` Show running containers

```docker ps -a``` Show all containers

## Building
```docker build -t TAG .``` build the Dockerfile in the current directory with tag 'TAG'

```docker build -t cloudzuid.nl/mdeheij/hallo .``` build the Dockerfile in the current directory with tag 'cloudzuid.nl/mdeheij/hallo'

## Images
```docker images``` Show images

```docker pull ubuntu``` Pull docker image from (official Docker hub) registry

```docker pull cloudzuid.nl/geheim``` Pull '_/geheim' image from 'https://cloudzuid.nl/' registry

```docker pull cloudzuid.nl/mdeheij/geheim``` Pull 'mdeheij/geheim' image from private cloudzuid registry

```docker push cloudzuid.nl/mdeheij/geheim``` Same but pushing

## GTA San Andreas
``` L1, L2, R1, R2, UP, DOWN, LEFT, RIGHT, L1, L2, R1, R2, UP, DOWN, LEFT, RIGHT. ``` Jetpack op PlayStation 2

# Opdracht 1
In de map opdracht1 bevindt zich een recept voor een image (Dockerfile). Pas de Dockerfile aan, maar raak index.php niet aan.

Bouw het image: 
```docker build -t step1 .```

Start de container, waarbij hij zichzelf opruimt na exit `--rm`, interactief + tty `-it`, en op de machine poort 80 koppelt aan poort 1337 van de container:
```docker run --rm -it -p 80:1337 step1``` 

**Doel: zorg dat "Ga door naar opdracht 2." verschijnt op de pagina. Er zijn meerdere wegen naar Container-Rome**

Tips:
* https://docs.docker.com/engine/reference/builder/
* `docker help run`

# Opdracht 2
Gebruik de map `supermarkt` voor de volgende opdrachten.

Voor de volgende opdracht is er reeds een Docker image beschikbaar op onze private registry. 
Je kunt deze downloaden met:
```docker pull cloudzuid.nl/supermarkt```

Maar als je hem niet hebt en simpelweg ```docker run cloudzuid.nl/supermarkt```, downloadt 'ie hem automatisch. Maar we gaan nu verder dan simpele eenzame containers.

*Je kunt hem ook zelf (her)bouwen, Dockerfile zit in de map. `docker build -t cloudzuid.nl/supermarkt .`. Maar je hoeft het image niet aan te raken om de opdrachten te doen*

In opdracht 2 blijkt dat een supermarkt een smerige applicatie heeft om de producten te bekijken uit hun database. Ze willen dit graag in Docker verpakken, met een compose yaml. Opdracht 2 heeft al een stack.yml, die kun je aanvullen.

TODO: 
* Databaseserver moet in de stack komen (tip: https://hub.docker.com/_/mariadb/)
* Database moet resolven met "databasebak", user 'root' hebben, password 'yoloistochlokaal' en databasenaam 'supermarkt'.
* De database moet deze query kunnen hebben `SELECT id, name FROM producten`
* Je zult op een of andere manier een database en tabel `producten` aan moeten maken. Als je geen wonder bent met queries uitvoeren, kun je ook adminer of phpMyAdmin erbij hangen. Poorten genoeg!
* Containers zijn in principe throw-away. Zorg dat de database niet foetsie is zodra de container komt te overlijden. Mount / maak een volume! Dat kan ook in je compose file!

De supermarkt is hip en gebruikt al een tijdje environment variables om de database te configureren:

```php
$servername = getenv('SUPERMARKT_DB_HOST');
$username = getenv('SUPERMARKT_DB_USER');
$password = getenv('SUPERMARKT_DB_PASS');
$dbname = getenv('SUPERMARKT_DB_NAME');
```

Docs:
* https://docs.docker.com/compose/compose-file/
* https://docs.docker.com/engine/reference/commandline/exec/#examples
* `docker stack deploy -c stack.yml supermarkt` helpt vast. 'opdracht2' is hierin de naam die onze stack heeft gekregen van ons.

Trivia:
* Opnieuw een stack deployen update de omgeving waar deze veranderd is. Een nieuw image werkt alleen als ie lokaal veranderd is (opnieuw gebouwd) of als ie van een registry komt. Dan wordt de checksum vergeleken.
* Docker zet intern een eigen network op voor je stack, standaard. Je kunt daar ook mee rommelen als je iets anders wilt.
* (!!) Het kan even duren voordat je stack volledig is geüpdatet! Heb geduld, maar niet teveel. Kijk vooral wat er gebeurt met `docker service ls`, `docker ps -a` enz.
* Werkt de stack alsnog niet mee na een redeploy, gooi hem weg `docker stack rm supermarkt` en deploy nogmaals.

# Opdracht 3
De supermarkt is echt heel blij dat hun ranzigheid nu iets beter is! Maar ze lopen tegen wat schalingsproblemen aan. Ze willen graag 5 PHP-containers hebben. Ook hier kun je het tijdelijk oplossen, maar het liefst wil je het in de yaml zetten.

# Opdracht 4
De operations afdeling van de supermarkt heeft de monitoring verkloot en je wilt het maar zelf gaan doen. Voorzie je compose yaml (stack) van een healthcheck, update_config- en restart policy. Als je toch bezig bent

# Opdracht 5
Het bleek dat het niet zo heel lekker meer draaide op één machine. Vraag een nieuwe VM aan óf, gebruik je eigen VPS (moet een vm zijn), óf als ze op zijn, zoek een ander team dat ook al zo ver is.

Hierbij moet één van de VM's de rol manager krijgen (standaard), en de andere VM die swarm joinen met de token die wordt gegeven bij het aanmaken. Ben je die kwijt: `docker swarm leave` en probeer het opnieuw. (`--force` wil je misschien erbij hebben)

TIP: Hoewel de PHP-containers hun bestanden in het image hebben, heeft de databaseserver 'state'. Dit repliceert niet zo goed, dus zorg ervoor dat je maar één databaseserver wilt hebben op één specifieke node (VM).

Misschien komt dit van pas:
* https://docs.docker.com/network/overlay/#operations-for-all-overlay-networks

# Bonus opdracht

Verpak een applicatie naar keuze (bijvoorbeeld een Symfony app) in Docker. 

Let op: je zit op een externe machine die niet bij alles kan. Ga ook zorgvuldig om met eventuele gevoeligheden als wachtwoorden.

# Ik-ben-er-klaar-mee opdracht

Probeer te bedenken hoe je volledige root access zou kunnen krijgen met alleen toegang tot Docker. Uiteraard mag je het ook op je eigen VM testen.
