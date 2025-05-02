function toggleNav() {
  const sidebar = document.querySelector('.sidebar');
  if (sidebar.classList.contains('closed')) {
      openNav();
  } else {
      closeNav();
  }
}

function openNav() {
  document.querySelector('.sidebar').classList.remove('closed');
  document.querySelector('.sidebar').classList.add('opened');
}

function closeNav() {
  document.querySelector('.sidebar').classList.remove('opened');
  document.querySelector('.sidebar').classList.add('closed');
}