// Credits goes to Eduardo Moreno
// Link to CodePen page https://codepen.io/emoreno911/pen/yXvZxd

tooglePage1();
//By default, to toggle on Categories section
$('.search').hide();


function tooglePage1() {

  $('.covers').removeClass('up');
  //remove automatic click when invoking function in showSeats
  //this is done because once clicked and you go back and re load the seats, you can no longer select seats! FIXED
  $('.seats').off("click");
  setTimeout(() => $('.main header').toggleClass('loaded'), 50);
  setTimeout(() => $('.covers').toggleClass('loaded'), 600);
}

var $covers = $('.covers');
var scroll = 0;
var delta = 267;//A value that ensures when a scroll occurs, it skips purely one row of covers.Does not scroll in half or less than half.

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

//Last function of file
var data = getData();
var index = evt.currentTarget.getAttribute('data-index');
var movie = data.results[parseInt(index)];
var title = movie.title;

// Text too large
var txt = movie.overview.length >= 220 ? movie.overview.substring(0, 220).concat('...') : movie.overview;

var $sinopsis = $('.sinopsis');
//Display movie data by modifying html elements and inserting values retrieved from movie object
$sinopsis.find('h3').text(movie.title);
$sinopsis.find('p').text(txt);
$sinopsis.find('img').attr('src', `https://image.tmdb.org/t/p/w300${movie.poster_path}`);
$sinopsis.find('span').text(`Release Date: ${movie.release_date}`);  

  //User will not be able to click on posters if viewing on Categories panel
  if(movie.showing == false || $('.filter li').hasClass('selected')){
    //Disables click on poster
  } else {

    $('.main').toggleClass('page2');
    $('.menu li').off('click');
    tooglePage1();
  }
  //To pass movie title in showSeats
  showSeats(title);
});

$('button.scrollDown').on('click', evt => doScroll());
$('button.scrollTop').on('click', evt => doScroll(true));

$('button.back').on('click', evt => {
  $('.main').toggleClass('page2');

  $('.total button').removeClass('success').text('CHECKOUT');
  tooglePage1();
  //Reload to reset Day value to Monday
  location.reload();
});


//Covers to display for Categories Panel
function doMoviesRender(filter) {

  var movies = getData().results;
  var moviesRender = movies.map((item, index) => {   
  var {
      //The attributes that matters in objects of getData
      title,
      genre_ids,
      poster_path,
      runtime } = item;

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

//For Search Box
function doMoviesRenderByName(movieName) {

  var movies = getData().results;
  var moviesRender = movies.map((item, index) => {

  var {
      title,
      poster_path,
      runtime } = item;

      var uri = `https://image.tmdb.org/t/p/w300/${poster_path}`;

      if(item.title == movieName){
        
      return `<li data-index="${index}">
        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8zw8AAhMBENYXhyAAAAAASUVORK5CYII=" style="background-image: url(${uri})">
        <span>${movieName}</span><small>${runtime}</small>
      </li>`;
      }
});
      $('.covers').html(moviesRender.join(''));

}


//For Days Panel
function movieRenderDays(filter) {

  var movies = getData().results;
  var moviesRender = movies.map((item, index) => {
  var {
      title,
      shows,
      poster_path,
      runtime,
      release_date,
      overview } = item;
    // item refers to each 'array-object' in results
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

//By default, it displays all movies that are being played Monday(0).
movieRenderDays('0');


/*************************************************SEAT POSITIONING SYS**********************************************************/
var selected = [];//Local variable to be used to parse and display for each movie

function showSeats(title){

var seats = [];
var initPos = 65;//ASCII Code of A


//0 by default, otherwise, will display previous Total value when was last viewed!
$('.total span').text(`Rs0`);

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
  9 -17(9 seats) but this time, Math.floor(i / 9) is 1.Corresponds to B and so on until last I(ASCII Code is 73)ie 65 + 8
  */

  var aisle = i % 9 === 1 ? 'aisle-right' :
  i % 9 === 7 ? 'aisle-left' : '';// eg 7 % 9 = Remainder 7
  /*All seats that end with '2' is on aisle-right and all seats that end with '8' are aisle-left*/ 

  if (row === 'I')
  aisle = 'aisle-top';
  // Generating a seat and adding it to array seats 
  seats.push(`<div class="seat ${aisle}">${row}${i % 9 + 1}</div>`);
}

//Loading booked seats from database table `seatsbooked` using the php script get_seats.php
$.ajax({
              type: "POST",
              url: 'get_seats.php',
              data: {
                      movie: title,//Parameter
                      dayOfBooking: day
                    },
              success: function(data){

                      //data is $seats array returned from php file
                      //To read seat values
                      $.each(JSON.parse(data), function(index, val){

                        //Booked seat
                        var listItem = val;

                        $(".seats .seat").each(function(){
                        //Generated seat
                        var listVal = $(this).text();

                        //Matching booked seats with generated seats
                        if(listVal == listItem){
                          $(this).addClass("taken");
                    }
                   })
                })
              }
});

$('.seats').html(seats.join(''));


//Selecting a particular seat
$('.seats').on('click', '.seat', evt => {

  var $seat = $(evt.currentTarget);

  var element = $seat.html();//Refers to the seat selected e.g A1 , A5 etc

  //Toggling of selected seats
  if (!$seat.hasClass('taken')) {

    $seat.toggleClass('selected');
    var $sel = $seat.parent().find('.selected');
    var qty = $sel.length * 250;
    $('.total span').text(`Rs${qty}`.substring(0, 6));
  }

  if($seat.hasClass('selected')){

      selected.push(element);//Only push when selected

  } else {

    //Find element in array and remove!
    $seat.removeClass('selected');
    selected.splice(selected.indexOf(element), 1);
  }

});
}

//Search Functionality
$('.search').keyup(function(){

  var title = $('.search').val();

  if(title == ''){
    //To remain on same category after Search box is blank
    doMoviesRender(filter);
  }else{
    doMoviesRenderByName(title);
  }

})

//Categories section
var filter;//To reference in search bar

$('.filter li').on('click', evt => {

  $('.search').show();
  //Will not have selected class on Days Section when Categories are being viewed
  $('.menu li').removeClass('selected');
  $(evt.currentTarget).addClass('selected').siblings().removeClass('selected');
  var $covers = $('.covers').removeClass('loaded').removeClass('up');
  filter = evt.currentTarget.getAttribute('data-gid');
  doMoviesRender(filter);
  scroll = 0;
  setTimeout(() => $covers.toggleClass('loaded'), 100);
});

//Global var to pass to `log.php`
var day = "Monday";//by default

//Days Section
$('.menu li').on('click', evt => {

  $('.search').hide();
  //To reset previous value held on Search box before toggling
  $('.search').val('');
  //Will not have selected class on Categories Section when Days are being viewed
  $('.filter li').removeClass('selected');
  $(evt.currentTarget).addClass('selected').siblings().removeClass('selected');

  var $covers = $('.covers').removeClass('loaded').removeClass('up');
  var menu = evt.currentTarget.getAttribute('data-id');

  day = $(evt.currentTarget).text();
  console.log(day);

  movieRenderDays(menu);
  scroll = 0;
  setTimeout(() => $covers.toggleClass('loaded'), 100);

});


 $('.total button').on('click', function (evt) {

  var $button = $(evt.currentTarget);
  var total = $('.total span').text();
  var title = $('.checkout h3').text();


  if (!$button.hasClass('success') && total != 'Rs0') {

    //Will post the total value and title to log table: total is of VARCHAR in table `log` format is Rsx
    $.ajax({
              type: "POST",
              url: 'log.php',
              data: {
                    movie: title,
                    amount: total,
                    dayBooked: day,
                    seatsArray: selected
                    },
              success: function(data){

            }
    }); 

  var $loader = $('.loader').show();
  $button.text('Booking...');

   setTimeout(() => {
   $loader.hide();
   $button.html('<i class="zmdi zmdi-check-circle"></i> Movie Booked');
   $button.addClass('success');
   }, 1600);

  //Reload after 3 seconds, will not reload if total = 0
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
*/

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
        "title": "Joker",
        "poster_path": "/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg",
        "genre_ids": [28,80,18, 53],
        "shows": [1,6,5],
        "backdrop_path": "/n6bUvigpRFqSwmPp1m2YADdbRBc.jpg",
        "overview": "During the 1980s, a failed stand-up comedian is driven insane and turns to a life of crime and chaos in Gotham City while becoming an infamous psychopathic crime figure.",
        "runtime": "2h02m",
        "release_date": "2019-10-04"

    },{
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
        "shows": [4,5,6],
        "backdrop_path": "/jA0PHyZm4X4EAgdwKtCNCzrkk7E.jpg",
        "overview": "Third installment of the Dabanng film series.",
        "runtime": "2h45m",
        "release_date": "2019-12-20"
    },{
        "title": "Jumanji: The Next Level",
        "poster_path": "/9Vp8MKqrwRAtvACF7PBwbvdG4dq.jpg",
        "genre_ids": [28,12,35,14],
        "shows": [5,6],
        "backdrop_path": "/oLma4sWjqlXVr0E3jpaXQCytuG9.jpg",
        "overview": "Spencer returns to the world of Jumanji, prompting his friends, his grandfather and his grandfather’s friend to enter a different and more dangerous version to save him.",
        "runtime": "1h55m",
        "release_date": "2019-12-04"
    },{
        "title": "Tanhaji: The Unsung Warrior",
        "poster_path": "/vJVCoEcAUjw6g42tG9GFg4a21Pv.jpg",
        "genre_ids": [28,18,36],
        "shows": [4,5,6],
        "backdrop_path": null,
        "overview": "Tanhaji is a historical drama based on Subedar Taanaji Malusare, the military leader in the army of Chhatrapati Shivaji Maharaj, who lost his life in the battle at Fort of Sinhagad. This Om Raut's directorial venture stars Ajay Devgn in the lead role.",
        "runtime": "2h10m",
        "release_date": "2020-01-10"
    },{
        "title": "Sooryavanshi",
        "poster_path": "/q2P7gF7kebsoaVMMkxVmff8YnjM.jpg",
        "genre_ids": [28,80,18],
        "shows": [7],
        "showing": false,
        "backdrop_path": "/2rBpNfrWrPXlTshUtH9sflSUiqT.jpg",
        "overview": "The action-packed adventures of an anti-terror Squad in India.",
        "runtime": "",
        "release_date": "2020-05-22"
    }]
  };
}
