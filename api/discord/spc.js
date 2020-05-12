const {Client, MessageAttachment} = require('discord.js');
const client = new Client();
const { exec, execSync } = require('child_process')
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
const execWait = (cmd) => {
    return new Promise((resolve, reject)=> {
        execSync(cmd);
    });
}
function typing(channel) {
    return new Promise(function (resolve) {

        channel.startTyping();

    });
}


client.on('message', msg => {
    console.log(msg.author.id);
    if(msg.content.indexOf('!spc') !== -1){
        //console.log('kusa2');
        //msg.channel.startTyping();
        typing(msg.channel);
        try{
            msg.delete();
        }catch(e){
            console.log("草");
        }
        //console.log('kusa');
        console.log(msg.author.username);
        console.log(msg.author.avatarURL());
        if(msg.author.avatarURL() != null){
            var userIconURL = msg.author.avatarURL();
        }else{
            var userIconURL = msg.author.defaultAvatarURL;
        }
        let member = msg.guild.member(msg.author);
        let nickname = member ? member.displayName : msg.author.username;
        output = execSync('php '+__dirname+'/analyze_spc.php "'+msg.content+'" "'+nickname+'" "'+userIconURL+'"');
        console.log(output);
        const jsonObject = JSON.parse(fs.readFileSync(path.resolve(__dirname, './imgur_url.json'), 'utf8'));
        console.log(jsonObject.url);
        //sent_mes =  msg.reply('',{files: {jsonObject.url}});
        const attachment = new MessageAttachment(path.resolve(__dirname, '../../result.png'));
        msg.reply(attachment);
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
client.login(config.discord.spc.token); // botログイン
