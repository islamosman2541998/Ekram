document.addEventListener("DOMContentLoaded", function () {
  // ==================== NAVBAR TOGGLE FIX ====================
  const toggler = document.querySelector('.navbar-toggler');
  const hamburger = document.querySelector('.custom-hamburger');
  const navbarCollapse = document.querySelector('.navbar-collapse');

  if (toggler && hamburger) {
    toggler.addEventListener('click', function () {
      hamburger.classList.toggle('active');
    });

    if (navbarCollapse) {
      navbarCollapse.addEventListener('hidden.bs.collapse', function () {
        hamburger.classList.remove('active');
      });

      navbarCollapse.addEventListener('shown.bs.collapse', function () {
        hamburger.classList.add('active');
      });
    }

    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', function () {
        if (window.innerWidth < 992) {
          const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
          if (bsCollapse) {
            bsCollapse.hide();
          }
          hamburger.classList.remove('active');
        }
      });
    });
  }

  // ==================== SWIPER INITIALIZATION ====================

  // Banner Swiper
  const bannerSwiperElement = document.querySelector(".bannerSwiper");
  if (bannerSwiperElement) {
    const bannerSwiper = new Swiper(".bannerSwiper", {
      loop: true,
      slidesPerView: 1,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
    });
  }

  // Statistics Swiper
  const statisticsSwiperElement = document.querySelector(".statisticsSwiper");
  if (statisticsSwiperElement) {
    const statisticsSwiper = new Swiper(".statisticsSwiper", {
      loop: true,
      slidesPerView: 1,
      spaceBetween: 10,
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        480: {
          slidesPerView: 1,
          spaceBetween: 15,
        },
        640: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        720: {
          slidesPerView: 4,
          spaceBetween: 20,
        },
      },
    });
  }

  // Project Sections Swiper
  const projectSectionsElement = document.querySelector(".ProjectSections");
  if (projectSectionsElement) {
    const Cardswiper = new Swiper(".ProjectSections", {
      loop: true,
      autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
      slidesPerView: 3,
      spaceBetween: 30,
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },

        1024: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1030: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1400: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      navigation: {
        nextEl: ".ProjectSection-button-next",
        prevEl: ".ProjectSection-button-prev",
      },
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
    });
  }

  // Program Card Swiper
  const programcardElement = document.querySelector(".programcardSwiper");
  if (programcardElement) {
    const programSwiper = new Swiper(".programcardSwiper", {
      loop: true,
      navigation: {
        nextEl: ".programcard-button-next",
        prevEl: ".programcard-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1008: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
        1400: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      slidesPerView: 3,
      spaceBetween: 30,
    });
  }
 // Ramadan Project Swiper
  const ramdanProjectElementt = document.querySelector(".RamdanProjectSwiper");
  if (ramdanProjectElementt) {
    const ramdanSwiper = new Swiper(".RamdanProjectSwiper", {
      loop: false,
      navigation: {
        nextEl: ".RamdanProject-button-next",
        prevEl: ".RamdanProject-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 10,

        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
         1024: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1030: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
    
        1400: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      slidesPerView: 3,
      spaceBetween: 30,
    });
  }

  // Ramadan Project Swiper
  const ramdanProjectElement = document.querySelector(".RamdanProject");
  if (ramdanProjectElement) {
    const ramdanSwiper = new Swiper(".RamdanProject", {
      loop: false,
      navigation: {
        nextEl: ".RamdanProjectt-button-next",
        prevEl: ".RamdanProjectt-button-prev",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
          spaceBetween: 10,

        },
        640: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
         1024: {
          slidesPerView: 2,
          spaceBetween: 10,
        },
        1030: {
          slidesPerView: 3,
          spaceBetween: 20,
        },
    
        1400: {
          slidesPerView: 3,
          spaceBetween: 10,
        },
      },
      autoplay: {
        delay: 3000,
        disableOnInteraction: false,
      },
      slidesPerView: 3,
      spaceBetween: 30,
    });
  }

const mediaSwiperEl = document.querySelector(".media-grid.swiper");

if (mediaSwiperEl) {
  if (mediaSwiperEl.swiper) {
    mediaSwiperEl.swiper.destroy(true, true);
  }

  new Swiper(".media-grid.swiper", {
    loop: false,
    slidesPerView: 3,
    spaceBetween: 30,

    navigation: {
      nextEl: ".media-section-button-next",
      prevEl: ".media-section-button-prev",
    },

    breakpoints: {
      0: {
        slidesPerView: 1,
        spaceBetween: 10,
      },
      640: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      1024: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      1030: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1400: {
        slidesPerView: 3,
        spaceBetween: 10,
      },
    },

    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
  });
}


  // ==================== CARDS CLICK EVENT ====================
  const cards = document.querySelectorAll(".home .Card");
  cards.forEach((card, idx) => {
    card.addEventListener("click", function () {
      localStorage.setItem("selectedCardIndex", idx);
      window.location.href = "category.html";
    });
  });

  // ==================== AMOUNT BUTTONS ====================
  document.querySelectorAll(".swiper-slide").forEach(function (slide) {
    var amountBtns = slide.querySelectorAll(".amount-btn");
    amountBtns.forEach(function (btn) {
      btn.addEventListener("click", function () {
        amountBtns.forEach(function (b) {
          b.classList.remove("active-amount");
        });
        btn.classList.add("active-amount");
        var input = slide.querySelector(".custom-card-input");
        if (input) input.value = btn.textContent.replace(/[^\d]/g, "");
      });
    });
  });

  // ==================== FAST PAY FUNCTIONALITY ====================
  const fastPay = document.querySelector(".fast-pay");
  const fastPayContainer = document.querySelector(".fast-pay .container");
  const donationForm = document.querySelector(".fast-pay .donation-form");
  const donationOptions = document.querySelectorAll(".fast-pay .donation-option");
  const projectGroups = document.querySelectorAll(".fast-pay .project-group");
  const projectSelects = document.querySelectorAll(".fast-pay .project-select");
  const donationAmounts = document.getElementById("donation-amounts");
  const amountGroups = document.querySelectorAll(".fast-pay .amount-group");

  if (fastPayContainer) {
    fastPayContainer.addEventListener("click", function (e) {
      if (!fastPay.classList.contains("expanded")) {
        fastPay.classList.add("expanded");
      } else {
        fastPay.classList.remove("expanded");
      }
    });

    donationOptions.forEach((option) => {
      option.addEventListener("click", function (e) {
        e.stopPropagation();
        donationOptions.forEach((opt) => opt.classList.remove("active"));
        this.classList.add("active");

        const selectedOption = this.dataset.option;
        projectGroups.forEach((group) => {
          if (group.dataset.for === selectedOption) {
            group.style.display = "block";
          } else {
            group.style.display = "none";
          }
        });

        if (donationAmounts) {
          donationAmounts.style.display = "none";
        }

        projectSelects.forEach((select) => {
          select.selectedIndex = 0;
        });
      });
    });

    projectSelects.forEach((select) => {
      select.addEventListener("change", function () {
        if (donationAmounts) {
          donationAmounts.style.display = "block";
        }

        const donationType = this.dataset.type;
        amountGroups.forEach((group) => {
          if (group.dataset.for === donationType) {
            group.style.display = "block";
          } else {
            group.style.display = "none";
          }
        });
      });
    });

    const amountButtons = document.querySelectorAll(".fast-pay .amount-btn");
    amountButtons.forEach((button) => {
      button.addEventListener("click", function (e) {
        e.stopPropagation();
        const parentGroup = this.closest(".amount-group");
        const groupButtons = parentGroup.querySelectorAll(".amount-btn");
        groupButtons.forEach((btn) => btn.classList.remove("active"));
        this.classList.add("active");
        const amountValue = this.textContent.replace(/[^\d]/g, "");
        console.log("Selected amount:", amountValue);
      });
    });

    const initialActiveOption = document.querySelector(".fast-pay .donation-option.active");
    if (initialActiveOption) {
      const selectedOption = initialActiveOption.dataset.option;
      const correspondingGroup = document.querySelector(
        `.fast-pay .project-group[data-for="${selectedOption}"]`
      );
      if (correspondingGroup) {
        correspondingGroup.style.display = "block";
      }
    }

    if (donationForm) {
      donationForm.addEventListener("click", function (e) {
        e.stopPropagation();
      });
    }

    document.addEventListener("click", function (e) {
      if (
        fastPay.classList.contains("expanded") &&
        !fastPayContainer.contains(e.target) &&
        e.target !== fastPayContainer
      ) {
        fastPay.classList.remove("expanded");
      }
    });

    document.addEventListener("keydown", function (e) {
      if (e.key === "Escape" && fastPay.classList.contains("expanded")) {
        fastPay.classList.remove("expanded");
      }
    });
  }

  // ==================== ACTIVE NAV LINK ====================
  function setActiveNavLink() {
    const currentPage = window.location.pathname.split("/").pop();
    const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

    navLinks.forEach((link) => {
      link.classList.remove("active");
    });

    navLinks.forEach((link) => {
      const linkHref = link.getAttribute("href");
      if (
        linkHref === currentPage ||
        (currentPage === "" && linkHref === "index.html") ||
        (currentPage === "/" && linkHref === "index.html")
      ) {
        link.classList.add("active");
      }
    });
  }

  setActiveNavLink();
});
// 
const ramdanSwiper = new Swiper(".RamdanProjectSwiper", {
  loop: false,                
  centeredSlides: false,     
  slidesPerView: 1,
  spaceBetween: 14,
  watchOverflow: true,
  observer: true,
  observeParents: true,

  navigation: {
    nextEl: ".RamdanProject-button-next",
    prevEl: ".RamdanProject-button-prev",
  },

  breakpoints: {
    0: {
      slidesPerView: 1,
      spaceBetween: 14,
    },
    768: {
      slidesPerView: 2,
      spaceBetween: 24,
    },
    1025: {
      slidesPerView: 3,
      spaceBetween: 28,
    },
  },
});

window.addEventListener("load", () => {
  ramdanSwiper.update();
});
