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


  document.addEventListener('DOMContentLoaded', function() {
    const dropdownButton = document.getElementById('dropdown-button');
    const dropdownMenu = document.getElementById('dropdown-menu');

    dropdownButton.addEventListener('click', function() {
      dropdownMenu.classList.toggle('opacity-100');
      dropdownMenu.classList.toggle('invisible');
      dropdownMenu.classList.toggle('translate-y-0');
      dropdownMenu.classList.toggle('translate-y-4');
    });

    document.addEventListener('click', function(event) {
      if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
        dropdownMenu.classList.add('opacity-0');
        dropdownMenu.classList.add('invisible');
        dropdownMenu.classList.remove('translate-y-0');
        dropdownMenu.classList.add('translate-y-4');
      }
    });
  });

  const dropdownButton = document.getElementById('dropdown-button');
  const dropdownMenu = document.getElementById('dropdown-menu');
  const dropdownContainer = dropdownButton.parentElement;
  
  dropdownButton.addEventListener('click', (event) => {
      event.stopPropagation(); // Previene la chiusura del menu
      dropdownContainer.classList.toggle('open');
  });
  
  document.addEventListener('click', () => {
      if (dropdownContainer.classList.contains('open')) {
          dropdownContainer.classList.remove('open');
      }
  });
  
  dropdownMenu.addEventListener('click', (event) => {
      event.stopPropagation(); // Previene la chiusura quando si clicca dentro il menu
  });
  
