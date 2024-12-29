# Hotel_management
Ce projet est un site web dynamique conçu pour simplifier la gestion des réservations d'hôtel. Il permet aux utilisateurs de :
•	Consulter les chambres disponibles.
•	Réserver en ligne.
•	Offrir un tableau de bord sécurisé pour les administrateurs.
À travers cette application, j’ai cherché à offrir une expérience utilisateur fluide et intuitive, tout en mettant en avant des fonctionnalités essentielles à la gestion d’un hôtel moderne.

Fonctionnalités
Pages Publiques
•	Home Page:
o	Un carrousel dynamique mettant en avant plusieurs photos de l'hôtel.
o	Une navigation intuitive grâce à une barre de navigation permettant un accès rapide aux sections principales.
•	Contact Section:
o	Une section accessible depuis la barre de navigation pour contacter l'hôtel.
•	Room Reservation:
o	Les utilisateurs peuvent consulter les chambres disponibles avec des détails comme les prix et les capacités.
o	L’option 'Book Now' redirige vers une page de connexion ou d’inscription.
![homepage](https://github.com/user-attachments/assets/e5a6b7dc-c498-4cd3-a3b9-2e165c7fe7d3)
![homeaboutus](https://github.com/user-attachments/assets/628e896d-a9db-4bc2-b01b-30267a543951)
![homeourrooms](https://github.com/user-attachments/assets/ce6edc0c-4c11-4b81-86d0-1a8faaed52b8)
![homecontact](https://github.com/user-attachments/assets/191b2e12-d905-4232-815d-1f421ab3f461)
![reservation](https://github.com/user-attachments/assets/0356225a-f58b-4cbf-8a4a-792750645118)
![booknow](https://github.com/user-attachments/assets/2c64ead1-22c3-465f-a256-64ee81305a87)

Authentication
•	Login & Register:
o	Les utilisateurs doivent se connecter pour effectuer des réservations.
o	Les nouveaux utilisateurs peuvent s’inscrire via Register Now.
![login](https://github.com/user-attachments/assets/4ff5d0a5-1d53-4150-b784-81b11d90f0e6)
![register](https://github.com/user-attachments/assets/e0d4991b-31f8-4edb-85f7-4af57edb42ba)

Fonctionnalité Basée sur les Rôles
•	Client:
o	Peut consulter les chambres disponibles et effectuer des réservations.
o	Doit créer un compte pour accéder aux fonctionnalités de réservation.
•	Admin:
o	Dispose d'un tableau de bord sécurisé pour gérer les réservations.
o	Peut ajouter de nouvelles chambres via une page dédiée.
o	Peut accepter ou rejeter des demandes de réservation.
![admindashboard](https://github.com/user-attachments/assets/447b980e-bcdd-4f49-a5ab-504db2e6cd61)
![addroom](https://github.com/user-attachments/assets/18666bda-f3d5-4ed2-ba29-d6e79fc12208)



Technologies Utilisées
Frontend
•	HTML5: Structuration des pages web.
•	CSS3: Pour une mise en page moderne et responsive.
•	Bootstrap: Bibliothèque utilisée pour les composants dynamiques et la compatibilité multi-plateforme.
Backend
•	PHP: Pour les fonctionnalités dynamiques côté serveur.
•	Sessions PHP: Gestion des utilisateurs connectés.
Database
•	MySQL: Base de données pour la gestion des chambres, des utilisateurs et des réservations.

Instructions d'installation
1.	Configurer l'environnement :
o	Installez XAMPP 8.2.12 et démarrez Apache et MySQL.
2.	Cloner le projet :
o	Placez les fichiers du projet téléchargés depuis GitHub dans le répertoire htdocs de XAMPP.
3.	Configurer la base de données :
o	Accédez à http://localhost/phpmyadmin.
o	Créez une nouvelle base de données.
o	Importez le fichier hotel_management.sql dans cette base.
Lancer l'application :
Dans un navigateur, accédez à :
http://localhost/hotel_management


En conclusion
Ce projet a été conçu pour offrir une solution complète et facile à utiliser pour la gestion des hôtels. Merci de votre attention, et n'hésitez pas à explorer le projet sur GitHub.
