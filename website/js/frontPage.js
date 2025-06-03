window.addEventListener('DOMContentLoaded', function() {
  var card = document.querySelector('.card');
  if(card) card.classList.add('animated-fadeInUp');

  var modal = document.getElementById('getStartedModal');
  if(modal) {
    modal.addEventListener('show.bs.modal', function() {
      var modalContent = modal.querySelector('.modal-content');
      if(modalContent) modalContent.classList.add('animated-fadeInUp');
    });
    modal.addEventListener('hidden.bs.modal', function() {
      var modalContent = modal.querySelector('.modal-content');
      if(modalContent) modalContent.classList.remove('animated-fadeInUp');
    });
  }


  var btn = document.querySelector('.btn-outline-primary[data-bs-target="#getStartedModal"]');
  if(btn) {
    btn.classList.add('btn-animated-bounce');
    btn.addEventListener('mouseenter', function() {
      btn.classList.remove('btn-animated-bounce');
      // Force reflow to restart animation
      void btn.offsetWidth;
      btn.classList.add('btn-animated-bounce');
    });
    btn.addEventListener('mouseleave', function() {
      btn.classList.remove('btn-animated-bounce');
    });
  }
});