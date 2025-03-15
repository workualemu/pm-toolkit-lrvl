document.addEventListener("alpine:init", () => {
  if (!window.Alpine) {
    console.error("Alpine is not defined yet.");
    return;
  }

  Alpine.store("global", {
    isDarkModeEnabled: Alpine.$persist(false).as("_x_darkMode_on"),
    isMonochromeModeEnabled: false,
    isSearchbarActive: false,
    isSidebarExpanded: false,
    isRightSidebarExpanded: false,

    toggleDarkMode() {
      this.isDarkModeEnabled = !this.isDarkModeEnabled;
      document.documentElement.classList.toggle("dark", this.isDarkModeEnabled);
    },

    toggleSidebar() {
      this.isSidebarExpanded = !this.isSidebarExpanded;
      document.body.classList.toggle("is-sidebar-open", this.isSidebarExpanded);
    },

    removePreloader() {
      const preloader = document.querySelector(".app-preloader");
      if (!preloader) return;
      setTimeout(() => {
        preloader.classList.add("animate-[cubic-bezier(0.4,0,0.2,1)_fade-out_500ms_forwards]");
        setTimeout(() => preloader.remove(), 1000);
      }, 150);
    }
  });

  let firstTime = true;

  Alpine.effect(() => {
    Alpine.store("global").isDarkModeEnabled
      ? document.documentElement.classList.add("dark")
      : document.documentElement.classList.remove("dark");
  });

  Alpine.effect(() => {
    Alpine.store("global").isMonochromeModeEnabled
      ? document.body.classList.add("is-monochrome")
      : document.body.classList.remove("is-monochrome");
  });

  Alpine.effect(() => {
    Alpine.store("global").isSidebarExpanded
      ? document.body.classList.add("is-sidebar-open")
      : document.body.classList.remove("is-sidebar-open");
  });

  Alpine.effect(() => {
    if (Alpine.store("breakpoints").name && !firstTime) {
      Alpine.store("global").isSidebarExpanded = false;
      Alpine.store("global").isRightSidebarExpanded = false;
    }
  });

  Alpine.effect(() => {
    if (Alpine.store("breakpoints").smAndUp) {
      Alpine.store("global").isSearchbarActive = false;
    }
  });

  firstTime = false;
});
export const store = Alpine.store("global");