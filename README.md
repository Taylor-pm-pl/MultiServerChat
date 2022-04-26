<h1>MultiServerChat<img src="assets/images/icon.png" height="64" width="64" align="left"></img></h1><br/>

[![Lint](https://poggit.pmmp.io/ci.shield/David-pm-pl/MultiServerChat/MultiServerChat)](https://poggit.pmmp.io/ci/David-pm-pl/MultiServerChat/MultiServerChat)
[![Discord](https://img.shields.io/discord/942248186670641202.svg?label=&logo=discord&logoColor=ffffff&color=7389D8&labelColor=6A7EC2)](https://discord.gg/34PC5u9W)

**NOTICE:** This plugin branch is for PocketMine-MP 4. <br/>
✨ **Make it possible to chat on the entire server**
</div>

## All Features
- [x] Make it possible to chat on the entire server
- [x] Connect With MySql
- [ ] Setup in-game

## Commands
+ Type **/multiserverchat** or **/msc** For multi chat

## How To Setup ?
1. You need a MySQL database (Can be created with xampp, ...)
2. Create a user and have a password to avoid vulnerabilities occurring
3. Create a db with the name MultiServerChat
4. change the name (type) of `Current-Server` in config.yml For EX: You are setting up at the Lobby server, then `Current-Server` is set to Lobby
5. Enter all names (categories) except `Current-Server` for which you want to have connected chat in `List-server` in config.yml
6. Change the information in `DataBase` as `host` is the network ipv4 of the device you created in step 2, user is the user you created in step 2, password is the password you created in step 2.After, Save and test.

# Additional Notes

- If you found bugs or want to give suggestions, please visit <a href="https://github.com/David-pm-pl/MultiServerChat/issues">here</a> or join our Discord server.
- We accept all contributions! If you want to contribute, please make a pull request in <a href="https://github.com/David-pm-pl/MultiServerChat/pulls">here</a>.
