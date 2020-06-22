// press f11 to full page view
// Credits goes to Eduardo Moreno
// Link to CodePen page https://codepen.io/emoreno911/pen/yXvZxd

tooglePage1();

function openForm() {
  document.getElementById("myForm").style.display = "block";
  document.getElementById("down").style.visibility = "hidden";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
  document.getElementById("down").style.visibility = "visible";
}

function tooglePage1() {
  $('.covers').removeClass('up');
  setTimeout(() => $('.main header').toggleClass('loaded'), 50);
  setTimeout(() => $('.covers').toggleClass('loaded'), 600);
}

var $covers = $('.covers');
var scroll = 0;
var delta = 267;//A value that ensures when a scroll occurs, it skips purely one row of covers.
//Does not scroll in half or less than half.

function doScroll(scrollUp = false) {
  var listHeight = getComputedStyle(document.querySelector('ul.covers')).getPropertyValue('height');

  if (!scrollUp && scroll < parseInt(listHeight) - delta * 2) {
    scroll += delta;
    $covers.removeClass('up').
    find('li').css('transform', `translateY(-${scroll}px)`);
  }

  if (scrollUp && scroll >= delta) {
    scroll -= delta;
    $covers.addClass('up').
    find('li').css('transform', `translateY(-${scroll}px)`);
  }
}

// Data to display when cover is clicked.
$('.covers').on('click', 'li', evt => {
var data = getData();
var index = evt.currentTarget.getAttribute('data-index');
var movie = data.results[parseInt(index)];
// Text too large
var txt = movie.overview.length >= 220 ?
movie.overview.substring(0, 220).concat('...') :
movie.overview;

var $sinopsis = $('.sinopsis');
$sinopsis.find('h3').text(movie.title);
$sinopsis.find('p').text(txt);
$sinopsis.find('img').attr('src', `https://image.tmdb.org/t/p/w300${movie.poster_path}`);
//$sinopsis.find('small').text(`Runtime:  ${movie.runtime}`);
$sinopsis.find('span').text(`Release Date: ${movie.release_date}`);  

  if(movie.showing == false){
    //Disables click on poster
  }else{
    $('.main').toggleClass('page2');
    tooglePage1();
  }

});


$('button.scrollDown').on('click', evt => doScroll());
$('button.scrollTop').on('click', evt => doScroll(true));

$('button.back').on('click', evt => {
  $('.main').toggleClass('page2');
  $('.total button').removeClass('success').text('CHECKOUT');
  tooglePage1();
});

// https://image.tmdb.org/t/p/w300/w93GAiq860UjmgR6tU9h2T24vaV.jpg
//When a poster is clicked, the following is executed
function doMoviesRender(filter) {

  var movies = getData().results;
  var moviesRender = movies.map((item, index) => {   
  var {
      //The attributes that matters in objects of getData
      title,
      genre_ids,
      shows,
      poster_path,
      runtime,
      release_date,
      overview } = item;
    // item refers to each 'array-object' in results
    var uri = `https://image.tmdb.org/t/p/w300/${poster_path}`;
    var gid = genre_ids.toString();

    // Details to show on the poster(title, img, runtime)
    return gid.indexOf(filter) < 0 ? '' : `
      <li data-index="${index}">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8zw8AAhMBENYXhyAAAAAASUVORK5CYII=" style="background-image: url(${uri})">
        <span>${title}</span><small>${runtime}</small>
      </li>
    `;
});

    $('.covers').html(moviesRender.join(''));
}
doMoviesRender(',');//Refers to selected in html

function movieRenderDays(filter) {

  var movies = getData().results;
  var moviesRender = movies.map((item, index) => {
    // item refers to each 'array-object' in results
    var {
      //The attributes that matters in objects of getData
      title,
      genre_ids,
      shows,
      poster_path,
      runtime,
      release_date,
      overview } = item;

    var uri = `https://image.tmdb.org/t/p/w300/${poster_path}`;
    var sid = shows.toString();

      // Details to show on the poster(title, img, runtime)
      return sid.indexOf(filter) < 0 ? '' : `
      <li data-index="${index}">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8zw8AAhMBENYXhyAAAAAASUVORK5CYII=" style="background-image: url(${uri})">
        <span>${title}</span><small>${runtime}</small>
      </li>
    `;
  });

  $('.covers').html(moviesRender.join(''));

}
movieRenderDays('0');
//By default, it displays all movies that are being played TODAY rather than all movies that are being played during the week.
//This is because there is a function overloading.
//If removed, then all movies are displayed by default.
/*************************************************SEAT POSITIONING SYS**********************************************************/
var seats = [];
var initPos = 65;//ASCII Code of A

// In total, there are 80 seats
for (var i = 0; i < 80; i++) {
  // 9 Rows in total with 9 seats per row until the last row which has only 8 seats
  // aisle-right and aisle-left is perceived as per the position of the seat to the screen
  // Math.floor rounds an integer value down.It return the largest integer value that is less than or equal to a number
  var row = String.fromCharCode(initPos + Math.floor(i / 9));//Generating char from A,B,C,D up to I
  /*How rows are generated?
  Each row contains 9 seats
  So, consider multiple range values of i
  0 - 8(9 seats) when divided in Math.floor(i / 9) is 0.That is, 65 + 0 each time is 65 which is ASCII equivalent of A
  9 -17(9 seats) but this time, Math.floor(i / 9) is 1.Corresponds to B and so on until last I(ASCII Code is 73)ie 65 + 8*/

  var taken = i % 7 == 0 || i % 6 == 0 ? 'taken' : '';//Generating random taken seats
  // Can change either integer values and each time will generate random layout of taken seats

  var aisle = i % 9 === 1 ? 'aisle-right' :
  i % 9 === 7 ? 'aisle-left' : '';// eg 7 % 9 = Remainder 7
  /*All seats that end with '2' is on aisle-right and all seats that end with '8' are aisle-left*/ 

  if (row === 'I')
  aisle = 'aisle-top';
  // Generating a seat and adding it to array seats 
  seats.push(`<div class="seat ${taken} ${aisle}">${row}${i % 9 + 1}</div>`);
}
$('.seats').html(seats.join(''));
//The join() method creates and returns a new string by concatenating all of the elements in an array (or an array-like object)

$('.seats').on('click', '.seat', evt => {
  var $seat = $(evt.currentTarget);

  if (!$seat.hasClass('taken')) {
    $seat.toggleClass('selected');

    var $sel = $seat.parent().find('.selected');
    var qty = $sel.length * 250;
    $('.total span').text(`Rs${qty}`.substring(0, 6));
  }
});

//Categories section
$('.filter li').on('click', evt => {
  $(evt.currentTarget).addClass('selected').siblings().removeClass('selected');
  var $covers = $('.covers').removeClass('loaded').removeClass('up');
  var filter = evt.currentTarget.getAttribute('data-gid');
  doMoviesRender(filter);
  scroll = 0;
  setTimeout(() => $covers.toggleClass('loaded'), 100);
});

//Days Section
$('.menu li').on('click', evt => {
  $(evt.currentTarget).addClass('selected').siblings().removeClass('selected');
  var $covers = $('.covers').removeClass('loaded').removeClass('up');
  var menu = evt.currentTarget.getAttribute('data-id');
  movieRenderDays(menu);
  scroll = 0;
  setTimeout(() => $covers.toggleClass('loaded'), 100);
});

$('.total button').on('click', function (evt) {
  var $button = $(evt.currentTarget);
  var total = $('.total span').text();

  if (!$button.hasClass('success') && total !== 'Rs 0') {
    var $loader = $('.loader').show();
    $button.text('Booking...');

    setTimeout(() => {
      $loader.hide();
      $button.html('<i class="zmdi zmdi-check-circle"></i> Movie Booked');
      $button.addClass('success');
    }, 1600);
    //Reload after 3 seconds, cannot reload if total = 0
    setTimeout(function(){
    document.location.reload(true); }, 3000);
  }

});
/*******************************************************************************************************************************/
/*** END OF CODE ***/

// Information accessed through the API of moviedb
/*
      title,
      genre_ids,
      poster_path,
      release_date,
      overview 

      backdrop = Fanart ............ (Min Res)1280 x 720   (Max Res)3840 x 2160
      Supported img sizes for backdrop w300, w780, w1280, original
      Example https://image.tmdb.org/t/p/original/5pAGnkFYSsFJ99ZxDIYnhQbQFXs.jpg
      or https://image.tmdb.org/t/p/w1280/5pAGnkFYSsFJ99ZxDIYnhQbQFXs.jpg

      ALL objects should have the same amount/identical attributes as they are retrieved later.
*/

// function loadJSON(callback) {

//     var xobj = new XMLHttpRequest();
//     xobj.overrideMimeType("application/json");
//     xobj.open('GET', 'movie.json', true);
    
//     xobj.onreadystatechange = function() {

//         if (xobj.readyState === 4 && xobj.status === 200) {
//             // Required use of an anonymous callback 
//             // as .open() will NOT return a value but simply returns undefined in asynchronous mode
//             callback(xobj.responseText);
//         }
//     };
//     xobj.send(null);
// }



function getData() {
  return {
    "results": [{
        "title": "Terminator: Dark Fate",
        "poster_path": "/vqzNJRH4YyquRiWxCCOH0aXggHI.jpg",
        "genre_ids": [28,878],
        "shows": [0,1,2,3,4,5,6],
        "backdrop_path": "/a6cDxdwaQIFjSkXf7uskg78ZyTq.jpg",
        "overview": "More than two decades have passed since Sarah Connor prevented Judgment Day, changed the future, and re-wrote the fate of the human race. Dani Ramos is living a simple life in Mexico City with her brother and father when a highly advanced and deadly new Terminator – a Rev-9 – travels back through time to hunt and kill her. Dani's survival depends on her joining forces with two warriors: Grace, an enhanced super-soldier from the future, and a battle-hardened Sarah Connor. As the Rev-9 ruthlessly destroys everything and everyone in its path on the hunt for Dani, the three are led to a T-800 from Sarah’s past that may be their last best hope.",
        "runtime": "2h14m",
        "release_date": "2019-10-23"
    },{

        "title": "Fast & Furious Presents: Hobbs & Shaw",
        "poster_path": "/kvpNZAQow5es1tSY6XW2jAZuPPG.jpg",
        "genre_ids": [28,12,35],
        "shows": [0,3,4],
        "backdrop_path": "/qAhedRxRYWZAgZ8O8pHIl6QHdD7.jpg",
        "overview": "Ever since US Diplomatic Security Service Agent Hobbs and lawless outcast Shaw first faced off, they just have swapped smacks and bad words. But when cyber-genetically enhanced anarchist Brixton's ruthless actions threaten the future of humanity, both join forces to defeat him.",
        "runtime": "2h16m",
        "release_date": "2019-08-01"
    },{

        "title": "Housefull 4",
        "poster_path": "/aCJOZzWV6cpZ9p9tmfEzXq4EqN8.jpg",
        "genre_ids": [35,18],
        "shows": [0,3,4],
        "backdrop_path": "/5cFiMYfSvjSkJMj2RVlJXhdciD3.jpg",
        "overview": "Three couples who get separated from each other due to an evil ploy, reincarnate after 600 years and meet each other as history repeats itself again and their respective partners get mixed up this time.",
        "runtime": "2h30m",
        "release_date": "2019-10-25"
    },{

        "title": "War",
        "poster_path": "/7JeHrXR1FU57Y6b90YDpFJMhmVO.jpg",
        "genre_ids": [28,53],
        "shows": [0,6,5],
        "backdrop_path": "/5Tw0isY4Fs08burneYsa6JvHbER.jpg",
        "overview": "Khalid, is entrusted with the task of eliminating Kabir, a former soldier turned rogue, as he engages in an epic battle with his mentor who had taught him everything.",
        "runtime": "2h34m",
        "release_date": "2019-10-02"
    },{
        // Joker
        "title": "Joker",
        "poster_path": "/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg",
        "genre_ids": [28,80,18, 53],
        "shows": [1,6,5],
        "backdrop_path": "/n6bUvigpRFqSwmPp1m2YADdbRBc.jpg",
        "overview": "During the 1980s, a failed stand-up comedian is driven insane and turns to a life of crime and chaos in Gotham City while becoming an infamous psychopathic crime figure.",
        "runtime": "2h02m",
        "release_date": "2019-10-04"

    },{
        //Avengers: Endgame
        "title": "Avengers: Endgame",
        "poster_path": "/or06FN3Dka5tukK1e9sl16pB3iy.jpg",
        "genre_ids": [28,12,878],
        "shows": [6,5],
        "backdrop_path": "/7RyHsO4yDXtBv1zUU3mTpHeQ0d5.jpg",
        "overview": "After Thanos, an intergalactic warlord, disintegrates half of the universe, the Avengers must reunite and assemble again to reinvigorate their trounced allies and restore balance.",
        "runtime": "3h02m",
        "release_date": "2019-04-26"

    },{
        "title": "Toy Story 4",
        "poster_path": "/w9kR8qbmQ01HwnvK4alvnQ2ca0L.jpg",
        "genre_ids": [12,16,35,14,10751],
        "shows": [0,2,3,4],
        "backdrop_path": "/m67smI1IIMmYzCl9axvKNULVKLr.jpg",
        "overview": "Woody has always been confident about his place in the world and that his priority is taking care of his kid, whether that's Andy or Bonnie. But when Bonnie adds a reluctant new toy called \"Forky\" to her room, a road trip adventure alongside old and new friends will show Woody how big the world can be for a toy.",
        "runtime": "1h40m",
        "release_date": "2019-06-19"

    },{
        "title": "The Lion King",
        "poster_path": "/2bXbqYdUdNVa8VIWXVfclP2ICtT.jpg",
        "genre_ids": [12,16,18],
        "shows": [4,5],
        "backdrop_path": "/nRXO2SnOA75OsWhNhXstHB8ZmI3.jpg",
        "overview": "Simba idolises his father, King Mufasa, and takes to heart his own royal destiny. But not everyone in the kingdom celebrates the new cub's arrival. Scar, Mufasa's brother—and former heir to the throne—has plans of his own. The battle for Pride Rock is ravaged with betrayal, tragedy and drama, ultimately resulting in Simba's exile. With help from a curious pair of newfound friends, Simba will have to figure out how to grow up and take back what is rightfully his.",
        "runtime": "1h58m",
        "release_date": "2019-07-12"
    },{
      "title": "Dabangg 3",
      "poster_path": "/ZqBA7auDNnvfjaJWLm7BNxnDN9.jpg",
      "genre_ids": [18,28],
      "shows": [7],
      "showing": false,
      "backdrop_path": "/jA0PHyZm4X4EAgdwKtCNCzrkk7E.jpg",
      "overview": "Third installment of the Dabanng film series.",
      "runtime": "",
      "release_date": "2019-12-20"
    },{
      "title": "Jumanji: The Next Level",
      "poster_path": "/9Vp8MKqrwRAtvACF7PBwbvdG4dq.jpg",
      "genre_ids": [28,12,35,14],
      "shows": [7],
      "showing": false,
      "backdrop_path": "/oLma4sWjqlXVr0E3jpaXQCytuG9.jpg",
      "overview": "Spencer returns to the world of Jumanji, prompting his friends, his grandfather and his grandfather’s friend to enter a different and more dangerous version to save him.",
      "runtime": "",
      "release_date": "2019-12-04"
    },{
      "title": "Tanhaji: The Unsung Warrior",
      "poster_path": "/vJVCoEcAUjw6g42tG9GFg4a21Pv.jpg",
      "genre_ids": [28,18,36],
      "shows": [7],
      "showing": false,
      "backdrop_path": null,
      "overview": "Taanaji is a historical drama based on Subedar Taanaji Malusare, the military leader in the army of Chhatrapati Shivaji Maharaj, who lost his life in the battle at Fort of Sinhagad. This Om Raut's directorial venture stars Ajay Devgn in the lead role.",
      "runtime": "",
      "release_date": "2020-01-10"
    }]
  };

}