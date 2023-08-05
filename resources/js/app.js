import "./bootstrap";

$(document).ready(() => {
    /**
     * Preloader
     *
     */

    setTimeout(() => {
        $(".preloader").remove();
    }, 250);

    /**
     * Handle topbar dropdown.
     *
     */

    $(".admin-wrapper .topbar .dropdown-toggler").on("click", (e) => {
        !$(e.target)
            .closest(".topbar-dropdown")
            .find(".dropdown-menu")
            .hasClass("active")
            ? $(e.target)
                  .closest(".topbar-dropdown")
                  .find(".dropdown-menu")
                  .trigger("dropdown:show")
            : $(e.target)
                  .closest(".topbar-dropdown")
                  .find(".dropdown-menu")
                  .trigger("dropdown:hide");
    });

    $(".admin-wrapper .topbar-dropdown .dropdown-menu").on(
        "dropdown:show",
        (e) => {
            // Change arrow icon
            $(".admin-wrapper .topbar .dropdown-toggler .arrow").removeClass(
                "uil-angle-down"
            );
            $(".admin-wrapper .topbar .dropdown-toggler .arrow").addClass(
                "uil-angle-up"
            );

            $(".admin-wrapper .topbar-dropdown .dropdown-menu")
                .not(e.target)
                .trigger("dropdown:hide");

            $(e.target).addClass("active");
        }
    );

    $(".admin-wrapper .topbar-dropdown .dropdown-menu").on(
        "dropdown:hide",
        (e) => {
            // Change arrow icon
            $(".admin-wrapper .topbar .dropdown-toggler .arrow").addClass(
                "uil-angle-down"
            );
            $(".admin-wrapper .topbar .dropdown-toggler .arrow").removeClass(
                "uil-angle-up"
            );

            $(e.target).removeClass("active");
        }
    );

    /**
     * Handle sidebar.
     *
     */

    $(".admin-wrapper .topbar .sidebar-toggler").on("click", (e) => {
        e.stopPropagation();

        !$(".sidebar").hasClass("active")
            ? $(".admin-wrapper .sidebar").trigger("sidebar:show")
            : $(".admin-wrapper .sidebar").trigger("sidebar:hide");
    });

    $(".admin-wrapper .sidebar").on("sidebar:show", (e) => {
        $(".admin-wrapper .overlay").addClass("active");
        $(e.target).addClass("active");

        $(".admin-wrapper .topbar-dropdown .dropdown-menu").trigger(
            "dropdown:hide"
        );
    });

    $(".admin-wrapper .sidebar").on("sidebar:hide", (e) => {
        $(".admin-wrapper .overlay").removeClass("active");
        $(e.target).removeClass("active");
    });

    /**
     * Sidebar sidebar dropdown.
     *
     */

    $(".admin-wrapper .sidebar .dropdown-toggler").on("click", (e) => {
        !$(e.target)
            .closest(".sidebar-dropdown")
            .find(".dropdown-menu")
            .hasClass("active")
            ? $(e.target)
                  .closest(".sidebar-dropdown")
                  .find(".dropdown-menu")
                  .trigger("dropdown:show")
            : $(e.target)
                  .closest(".sidebar-dropdown")
                  .find(".dropdown-menu")
                  .trigger("dropdown:hide");
    });

    $(".admin-wrapper .sidebar-dropdown .dropdown-menu").on(
        "dropdown:show",
        (e) => {
            // Change arrow icon
            $(".admin-wrapper .sidebar .dropdown-toggler .arrow").removeClass(
                "uil-angle-down"
            );
            $(".admin-wrapper .sidebar .dropdown-toggler .arrow").addClass(
                "uil-angle-up"
            );

            $(".admin-wrapper .sidebar-dropdown .dropdown-menu")
                .not(e.target)
                .trigger("dropdown:hide");

            $(e.target).addClass("active");

            const sidebarLinkHeight = $(
                ".admin-wrapper .sidebar .sidebar-link"
            ).innerHeight();

            const sidebarLinkCount = $(e.target).find(".sidebar-link").length;

            $(e.target).css({
                height: `${sidebarLinkHeight * sidebarLinkCount}px`,
            });
        }
    );

    $(".admin-wrapper .sidebar-dropdown .dropdown-menu").on(
        "dropdown:hide",
        (e) => {
            // Change arrow icon
            $(".admin-wrapper .sidebar .dropdown-toggler .arrow").removeClass(
                "uil-angle-up"
            );
            $(".admin-wrapper .sidebar .dropdown-toggler .arrow").addClass(
                "uil-angle-down"
            );

            $(e.target).removeClass("active");

            $(e.target).css({
                height: "0px",
            });
        }
    );

    /**
     * Handle sidebar submenu active.
     *
     */

    if (
        $(
            ".admin-wrapper .sidebar-dropdown .dropdown-menu .sidebar-link.active"
        ).length
    ) {
        $(
            ".admin-wrapper .sidebar-dropdown .dropdown-menu .sidebar-link.active"
        )
            .closest(".dropdown-menu")
            .trigger("dropdown:show");
    }

    /**
     * Handle modal.
     *
     */

    $(".modal-trigger").on("click", (e) => {
        e.stopPropagation();

        const target = e.target.getAttribute("data-target");

        $(target).trigger("modal:show");
    });

    $(".modal-cancel-trigger").on("click", (e) => {
        $(e.target).closest(".modal").trigger("modal:hide");
    });

    $(".modal").on("modal:show", (e) => {
        $(e.target).addClass("show");
    });

    $(".modal").on("modal:hide", (e) => {
        $(e.target).removeClass("show");
    });

    if ($(".modal .invalid-field").length) {
        $($(".modal .invalid-field")[0].closest(".modal")).trigger(
            "modal:show"
        );
    }

    /**
     * Handle click outside.
     *
     */
    $(document).on("click", function (e) {
        // Sidebar

        if ($(e.target).closest(".sidebar").length === 0) {
            $(".admin-wrapper .sidebar").trigger("sidebar:hide");
        }

        // Dropdown

        if ($(e.target).closest(".topbar-dropdown").length === 0) {
            $(".admin-wrapper .topbar-dropdown > .dropdown-menu").trigger(
                "dropdown:hide"
            );
        }

        // Modal

        if ($(e.target).closest(".modal .modal-content").length === 0) {
            $(".modal").trigger("modal:hide");
        }
    });

    /**
     * Form trigger.
     *
     */

    $(".form-trigger").on("click", (e) => {
        const target = e.target.getAttribute("data-target");

        $(target).submit();
    });

    /**
     * Handle click trigger.
     *
     */

    $(".click-trigger").on("click", (e) => {
        const target = e.target.getAttribute("data-target");

        $(target).click();
    });

    /**
     * Handle alert.
     *
     */

    $(".alert .close-alert").on("click", (e) => {
        const alert = $(e.target).closest(".alert");

        alert.animate(
            {
                opacity: 0,
            },
            200
        );

        setTimeout(() => {
            alert.remove();
        }, 300);
    });

    /**
     * Handle refresh button.
     *
     */

    $(".clear-parameters").on("click", () => {
        window.location = window.location.href.split("?")[0];
    });
});
