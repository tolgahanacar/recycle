const offline = document.getElementById("offline");

window.addEventListener("online", () => {
  offline.style.display = "none";
});

window.addEventListener("offline", () => {
  offline.style.display = "block";
});
