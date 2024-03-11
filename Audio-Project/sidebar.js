function expandSidebar() {
    document.getElementById("sidebar").classList.add("expanded");
    document.getElementById("content").classList.add("expanded");
}

function collapseSidebar() {
    document.getElementById("sidebar").classList.remove("expanded");
    document.getElementById("content").classList.remove("expanded");
}
