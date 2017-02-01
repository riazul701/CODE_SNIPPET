###### Manual CRUD using CodeIgniter
1. This Gist uses Several CSS Library
   Bootstrap: 
2. This Gist uses Several Jquery Plugin
   Datatables for Grid: http://datatables.net/
3. This CRUD is for Folder Structure for Without any Panel (Admin, User panel).
   For Panel (Admin, User panel) add same folder structure inside every panel.
4. Create “crud” folder in Controller folder in codeigniter
5. Inside “controllers/crud” folder create one controller for per crud
6. Controller used separate function for add/edit/save/delete
7. Create “crud” folder in Model folder in codeigniter
8. Inside “models/curd” folder create one model for per crud. Model name will be in this format - “<controller_name>_model”
9. Model uses separate function for add/edit/save/delete
10. Create “crud” folder in Views folder in codeigniter
11. Inside “views/crud” folder create one folder for per crud. Folder name will be in this format - “<controller_name>”. Place necessary files inside this folder.