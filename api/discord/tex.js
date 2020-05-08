const {Client, MessageAttachment} = require('discord.js');
const client = new Client();
//const { exec, execSync } = require('child_process')
//const jsonObject = JSON.parse(fs.readFileSync(__dirname+'/../input.json', 'utf8'));
const path = require('path');
const fs = require("fs");
client.on('ready', () => {
  console.log(`Logged in as ${client.user.tag}!`);
});
var sent_mes = 0;
const wait = (sec) => {
    return new Promise((resolve, reject) => {
      setTimeout(resolve, sec*1000);
      //setTimeout(() => {reject(new Error("エラー！"))}, sec*1000);
    });
};
function execShellCommand(cmd) {
    const exec = require('child_process').exec;
    return new Promise((resolve, reject) => {
     exec(cmd, (error, stdout, stderr) => {
      if (error) {
       console.warn(error);
      }
      resolve(stdout? stdout : stderr);
     });
    });
   }
function typing(channel) {
    return new Promise(function (resolve) {

        channel.startTyping();

    });
}


client.on('message', async msg => {
    console.log(msg.author.id);
    if((msg.content.indexOf('!tex') !== -1)||(msg.content.indexOf('!md') !== -1)){
        //console.log('kusa2');
        //msg.channel.startTyping();
        typing(msg.channel);
        await msg.delete();
        //console.log('kusa');
        if(msg.author.avatarURL() != null){
            var userIconURL = msg.author.avatarURL();
        }else{
            var userIconURL = msg.author.defaultAvatarURL;
        }
        let member = msg.guild.member(msg.author);
        let nickname = member ? member.displayName : msg.author.username;
        output = await execShellCommand('php '+__dirname+'/analyze_tex.php "'+msg.cleanContent+'"');
        try {
            fs.statSync(path.resolve(__dirname, '../../result.png'));
            const attachment = new MessageAttachment(path.resolve(__dirname, '../../result.png'));
            msg.reply(attachment);
            } catch (error) {
            msg.reply('無理でした');
          }

        msg.channel.stopTyping();
    }
});

process.on('exit', function (code) {

});


process.on('SIGINT', function() {
    console.log('exiting program...');
    client.destroy();
    process.exit();
});
const config = JSON.parse(fs.readFileSync(path.resolve(__dirname, '../config.json'), 'utf8'));
console.log(config.discord.token);
client.login(config.discord.tex.token); // botログイン
