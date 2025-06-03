document.addEventListener("DOMContentLoaded", () => {
  const courseWrappers = document.querySelectorAll('.course-wrapper');
  const courseContainer = document.querySelector('.row.g-4');
  const searchBar = document.querySelector('.search-bar input');

  const loadMoreButton = document.createElement("button");
  loadMoreButton.textContent = "Load More Courses";
  loadMoreButton.className = "btn btn-outline-secondary mb-3 d-flex justify-content-center";
  courseContainer.parentElement.insertBefore(loadMoreButton, courseContainer);

  let coursesToShow = 9;

  
  const updateLoadMoreButtonVisibility = () => {
    const visibleCourses = Array.from(courseWrappers).filter(
      (wrapper) => wrapper.style.display !== "none"
    ).length;

    if (visibleCourses < courseWrappers.length) {
      loadMoreButton.style.display = "inline-block";
    } else {
      loadMoreButton.style.display = "none";
    }
  };

  loadMoreButton.addEventListener("click", () => {
    const totalCourses = courseWrappers.length;
    let startIndex = coursesToShow % totalCourses;

    // Hide all courses initially
    courseWrappers.forEach((wrapper) => {
      wrapper.style.display = "none";
    });

    // Show the next 9 courses in a cyclic manner
    for (let i = 0; i < 9; i++) {
      const index = (startIndex + i) % totalCourses;
      courseWrappers[index].style.display = "block";
    }

    coursesToShow += 9;
  });

  // Ensure the "Load More" button has proper styling
  loadMoreButton.style.margin = "0 auto"; // Center the button
  loadMoreButton.style.width = "fit-content"; // Prevent it from stretching

  // Show only the first 9 courses initially
  courseWrappers.forEach((wrapper, index) => {
    if (index >= 9) {
      wrapper.style.display = "none";
    }
  });

  let debounceTimeout;
  // Update the search bar logic to reset the "Load More" button
  searchBar.addEventListener("input", (e) => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
      const searchText = e.target.value.toLowerCase().trim();

      // Filter and sort matching courses
      const matchingCourses = Array.from(courseWrappers).filter((wrapper) => {
        const courseName = wrapper.querySelector(".card-title").textContent.toLowerCase();
        const courseDescription = wrapper.querySelector(".card-text").textContent.toLowerCase();
        return courseName.includes(searchText) || courseDescription.includes(searchText);
      }).sort((a, b) => {
        const aName = a.querySelector(".card-title").textContent.toLowerCase();
        const bName = b.querySelector(".card-title").textContent.toLowerCase();

        if (aName.startsWith(searchText) && !bName.startsWith(searchText)) return -1;
        if (!aName.startsWith(searchText) && bName.startsWith(searchText)) return 1;
        return 0;
      });

      // Clear the container and append sorted courses
      courseContainer.innerHTML = "";
      matchingCourses.forEach((course) => {
        course.style.display = "block";
        courseContainer.appendChild(course);
      });

      // Reset to the first 9 courses if no search text
      if (!searchText) {
        courseWrappers.forEach((wrapper, index) => {
          wrapper.style.display = index < 9 ? "block" : "none";
          courseContainer.appendChild(wrapper);
        });
      }

      updateLoadMoreButtonVisibility();
    }, 300); 
  });

  courseWrappers.forEach((wrapper) => {
    const enrollButton = wrapper.querySelector(".btn");
    enrollButton.addEventListener("click", () => {
      const courseID = wrapper.querySelector("input[name='courseID']").value;
      const courseName = wrapper.querySelector(".card-title").textContent;
      const courseDescription = wrapper.querySelector(".card-text").textContent;
      const coursePrice = wrapper.getAttribute("data-course-price");

      showConfirmation(courseID, courseName, courseDescription, coursePrice);
    });
  });
});