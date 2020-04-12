const Discord = require('discord.js');
const client = new Discord.Client();
const { exec, execSync } = require('child_process')
//const jsonObject = JSON.parse(fs.readFileSync(__dirname+'/../input.json', 'utf8'));
const path = require('path');
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

client.on('message', async msg => {
    if(msg.content.indexOf('!5cho') !== -1){
        //console.log('kusa2');
        msg.channel.startTyping();
        //console.log('kusa');
        output = await execSync('php '+__dirname+'/analyze.php "'+msg.content+'"');
        console.log(output);
        const jsonObject = require(__dirname+'/imgur_url.json');
        console.log(jsonObject[url]);
        msg.channel.stopTyping();
        sent_mes =  msg.reply('pong');
        msg.delete();
       
    }
});

process.on('exit', function (code) {

});


process.on('SIGINT', function() {
    console.log('exiting program...');
    client.destroy();
    process.exit();
});
const config = require(__dirname+'/../console.json');
client.login(config[discord][token]); // botログイン

