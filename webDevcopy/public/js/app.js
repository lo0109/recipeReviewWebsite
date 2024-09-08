document.getElementById('reviewForm').addEventListener('submit', function(event) {
    const rating = document.querySelector('input[name="rating"]:checked');
    const comment = document.getElementById('comment').value.trim();
    
    if (!rating || rating.value < 1 || rating.value > 5) {
      document.getElementById('ratingError').textContent = 'Please select a valid rating between 1 and 5.';
      event.preventDefault();
    }
  
    if (comment.split(/\s+/).length < 3) {
      document.getElementById('commentError').textContent = 'Your comment must contain at least 3 words.';
      event.preventDefault();
    }
  });
  