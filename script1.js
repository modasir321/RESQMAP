document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.slider');
    const videos = document.querySelectorAll('.slider video');

    let currentVideo = 0;

    function playNextVideo() {
        const nextVideo = (currentVideo + 1) % videos.length;
        videos[nextVideo].currentTime = 0; // Reset video to start
        videos[currentVideo].pause();
        currentVideo = nextVideo;
        updateSlider();
        videos[currentVideo].play();
        setTimeout(playNextVideo, 5000); // Adjust the interval (in milliseconds) for each video
    }

    function updateSlider() {
        const translateValue = -currentVideo * 100;
        slider.style.transform = `translateX(${translateValue}%)`;
    }

    playNextVideo();
});



  $(document).ready(function () {
    $("#Heading1").css({ "opacity": "0", "transform": "translateY(20px)" });
    $("#Heading1").animate({
        opacity: 1,
        translateY: 0
    }, 4000); 
});


      $(document).ready(function () {
          $(".Centre").css({ "opacity": "0", "transform": "translateY(3px)" });
          $(".Centre").animate({
              opacity: 1,
              translateY: 0
          }, 4000); 
      });
  
  

  


$(document).ready(function () {
  $('.emergency-box').hover(
      function () {
          $(this).stop().animate({ marginLeft: '100px' }, 200);
      },
      function () {
          $(this).stop().animate({ marginLeft: '20px' }, 200);
      }
  );
});





