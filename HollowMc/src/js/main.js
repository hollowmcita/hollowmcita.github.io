// Main Scripts //

function getDiscordMembers(guild, startstringsingle, endstringsingle, startstringmulti, endstringmulti) {
  $.get("https://discordapp.com/api/guilds/" + guild + "/embed.json", function(data) {
      let output = (data["presence_count"] == 1) ?
          (startstringsingle + " " + data["presence_count"] + " " + endstringsingle) :
          (startstringmulti + " " + data["presence_count"] + " " + endstringmulti);
      $("#discordcount").html(output);
  });
}

function getMinecraftPlayers(ip, startstringsingle, endstringsingle, startstringmulti, endstringmulti) {
  $.getJSON("https://api.mcsrvstat.us/1/" + ip, function(data) {
      let output = (data.players.online == 1) ?
          (startstringsingle + " " + data.players.online + " " + endstringsingle) :
          (startstringmulti + " " + data.players.online + " " + endstringmulti);
      $("#minecraftcount").html(output);
  });
}

var clipboard = new ClipboardJS('.copy');

window.onload = function() {
  getDiscordMembers("1211782052022718474", "", "player online", "", "player online");
  getMinecraftPlayers("play.hollowmc.it", "", "player online", "", "player online");
  setInterval(function() {
      getMinecraftPlayers("play.hollowmc.it", "", "player online", "", "player online");
  }, 60 * 1000);
}

let item = document.querySelector('.icon-hamburger');
item.addEventListener("click", function() {
  document.body.classList.toggle('menu-open');
});