document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".container");
    container.addEventListener("mousemove", (event) => {
        const x = (event.clientX / window.innerWidth - 0.5) * 20;
        const y = (event.clientY / window.innerHeight - 0.5) * 20;
        container.style.transform = `rotateX(${-y}deg) rotateY(${x}deg)`;
    });
    container.addEventListener("mouseleave", () => {
        container.style.transform = "rotateX(0deg) rotateY(0deg)";
    });
});
