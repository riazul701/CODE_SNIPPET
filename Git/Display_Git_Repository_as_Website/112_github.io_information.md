###### Using **github.io**
1. **Create a repository**. Head over to GitHub and create a new repository named username.github.io, where username is your username (or organization name) on GitHub.If the first part of the repository doesn’t exactly match your username, it won’t work, so make sure to get it right.
2. **What git client are you using?** --- A terminal
3. **Clone the repository**. Go to the folder where you want to store your project, and clone the new repository: 
```
git clone https://github.com/username/username.github.io
```
4. **Hello World**. Enter the project folder and add an index.html file:
```
cd username.github.io
echo "Hello World" > index.html
```
5. **Push it**. Add, commit, and push your changes:
```
git add --all
git commit -m "Initial commit"
git push -u origin master
```
6. **…and you're done!** Fire up a browser and go to http://username.github.io.