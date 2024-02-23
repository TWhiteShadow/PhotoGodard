export default class SidebarObserver { 

    init(){
        // Using an observer to detect when the user scrolls the page and which sections is being seen
        const sections = document.querySelectorAll("section");
        const sidebarSpans = document.querySelectorAll("#sidebar span");

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        sidebarSpans.forEach((span) => {
                            if (
                                entry.target.id ===
                                span.parentElement.getAttribute("href").substring(1)
                            ) {
                                span.parentElement.classList.add("active");
                                history.pushState(
                                    null,
                                    null,
                                    span.parentElement.getAttribute("href")
                                );
                            } else {
                                span.parentElement.classList.remove("active");
                            }
                        });
                    } else {
                    }
                });
            },
            {
                threshold: 0.1,
            }
        );

        sections.forEach((element) => {
            observer.observe(element);
        });

    }


}