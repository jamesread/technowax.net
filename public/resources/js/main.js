function sidebarToggle() {
  let isSidebar = window.matchMedia('(max-width: 600px)').matches
  
  if (!isSidebar) {
    return;
  }

  let expandedWidth = "auto";
  let closedWidth = "0px";
  let button = document.querySelector('#sidebarToggle');

  let sidebar = document.querySelector('nav');
  let state = sidebar.getAttribute('state');

  if (state == 'open' || state == null) {
    sidebar.setAttribute('state', 'closed')
    sidebar.style.width = closedWidth; 
    button.innerHTML = '&equiv; Menu';
  } else {
    sidebar.setAttribute('state', 'open')
    sidebar.style.width = expandedWidth; 
    button.innerHTML = '&laquo; Close';
  }
}

