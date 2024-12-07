!(function (l) {
  "use strict";
  function e() {
    this.$body = l("body");
    this.$modal = l("#event-modal");
    this.$calendar = l("#calendar");
    this.$formEvent = l("#form-event");
    this.$btnNewEvent = l("#btn-new-event");
    this.$btnDeleteEvent = l("#btn-delete-event");
    this.$btnSaveEvent = l("#btn-save-event");
    this.$modalTitle = l("#modal-title");
    this.$calendarObj = null;
    this.$selectedEvent = null;
    this.$newEventData = null;
    this.$bootstrapModal = null;
  }

  e.prototype.onEventClick = function (info) {
    this.$formEvent[0].reset();
    this.$formEvent.removeClass("was-validated");
    this.$newEventData = null;
    this.$btnDeleteEvent.show();
    this.$modalTitle.text("Edit Event");
    this.$bootstrapModal.show();

    this.$selectedEvent = info.event;
    l("#event-title").val(this.$selectedEvent.title);
    l("#event-category").val(this.$selectedEvent.classNames[0]);
  };

  // In the onSelect method, add more robust date handling
  e.prototype.onSelect = function (info) {
    this.$formEvent[0].reset();
    this.$formEvent.removeClass("was-validated");
    this.$selectedEvent = null;

    // More robust date handling with fallback
    this.$newEventData = info || {};
    this.$newEventData.dateStr =
      info?.dateStr ||
      (moment().isValid()
        ? moment().format("YYYY-MM-DD")
        : new Date().toISOString().split("T")[0]);
    this.$newEventData.allDay = info?.allDay ?? true;

    this.$btnDeleteEvent.hide();
    this.$modalTitle.text("Add New Event");
    this.$bootstrapModal.show();
    this.$calendarObj.unselect();
  };

  e.prototype.init = function () {
    var self = this;

    // Initialize Bootstrap Modal
    this.$bootstrapModal = new bootstrap.Modal(
      document.getElementById("event-modal"),
      {
        keyboard: false,
      }
    );

    // Draggable external events
    new FullCalendar.Draggable(document.getElementById("external-events"), {
      itemSelector: ".external-event",
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText,
          className: l(eventEl).data("class"),
        };
      },
    });

    // Initialize Calendar
    this.$calendarObj = new FullCalendar.Calendar(this.$calendar[0], {
      slotDuration: "00:15:00",
      slotMinTime: "08:00:00",
      slotMaxTime: "23:59:59",
      locale: "en-PH",
      themeSystem: "bootstrap",
      buttonText: {
        today: "Today",
        month: "Month",
        week: "Week",
        day: "Day",
        list: "List",
      },
      initialView: "dayGridMonth",
      handleWindowResize: true,
      height: l(window).height() - 200,
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth",
      },
      editable: true,
      droppable: true,
      selectable: true,

      // Fetch events from backend
      events: function (fetchInfo, successCallback, failureCallback) {
        console.log("Fetching events from:", fetchInfo.startStr);
        console.log("Fetching events to:", fetchInfo.endStr);

        l.ajax({
          url: "event-handler.php",
          method: "GET",
          data: {
            action: "list",
            start: fetchInfo.startStr,
            end: fetchInfo.endStr,
          },
          dataType: "json",
          success: function (response) {
            // Log each event's date
            response.forEach((event) => {
              console.log("Event:", event.title, "Start:", event.start);
            });
            successCallback(response);
          },
          error: function (xhr, status, error) {
            console.error("Event fetch error:", error);
            failureCallback(error);
          },
        });
      },

      drop: function (info) {
        // Clean and prepare event data
        var cleanTitle = info.draggedEl.innerText.trim();
        var category = l(info.draggedEl).data("class") || "bg-primary";

        // Prepare event data
        var eventData = {
          title: cleanTitle,
          start: moment(info.dateStr).format("YYYY-MM-DD HH:mm:ss"),
          end: moment(info.dateStr)
            .add(1, "hour")
            .format("YYYY-MM-DD HH:mm:ss"),
          all_day: info.allDay,
          category: category,
          action: "create",
        };

        // If not an all-day event, add a default duration
        if (!info.allDay) {
          var startMoment = moment(info.dateStr);
          eventData.end = startMoment.add(1, "hour").format();
        }

        // AJAX request to create event
        l.ajax({
          url: "event-handler.php",
          method: "POST",
          data: eventData,
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              // Add event to calendar with server-confirmed details
              self.$calendarObj.addEvent({
                id: response.id,
                title: eventData.title,
                start: response.start,
                end: response.end,
                allDay: eventData.all_day,
                className: [category],
              });
            } else {
              alert(
                "Failed to create event: " + (response.error || "Unknown error")
              );
            }
          },
          error: function (xhr, status, error) {
            console.error("Event creation error:", error);
            alert("Failed to create event: " + error);
          },
        });
      },

      // Prevent FullCalendar from automatically creating events
      eventReceive: function (info) {
        info.event.remove();
      },

      // Handle date click
      dateClick: function (info) {
        self.onSelect(info);
      },

      // Handle event click
      eventClick: function (info) {
        self.onEventClick(info);
      },
    });

    // Render calendar
    this.$calendarObj.render();

    // New event button handler
    this.$btnNewEvent.on("click", function () {
      self.onSelect({
        date: new Date(),
        allDay: true,
      });
    });

    // Form submission handler
    this.$formEvent.on("submit", function (e) {
      e.preventDefault();
      var form = self.$formEvent[0];

      if (form.checkValidity()) {
        var eventData = {
          title: l("#event-title").val(),
          category: l("#event-category").val(),
          start: self.$selectedEvent
            ? self.$selectedEvent.startStr
            : self.$newEventData && self.$newEventData.dateStr
            ? self.$newEventData.dateStr
            : moment().format("YYYY-MM-DD"),
          end: self.$selectedEvent
            ? self.$selectedEvent.endStr || self.$selectedEvent.startStr
            : self.$newEventData && self.$newEventData.dateStr
            ? self.$newEventData.dateStr
            : moment().format("YYYY-MM-DD"),
          all_day: self.$newEventData
            ? self.$newEventData.allDay !== undefined
              ? self.$newEventData.allDay
              : true
            : true,
          action: self.$selectedEvent ? "update" : "create",
          id: self.$selectedEvent ? self.$selectedEvent.id : null,
        };

        // Set the className based on the category
        eventData.className = [eventData.category || "bg-primary"];

        // Log the data being sent
        console.log("Sending event data:", eventData);

        l.ajax({
          url: "event-handler.php",
          method: "POST",
          data: eventData,
          dataType: "json",
          success: function (response) {
            console.log("Server response:", response);
            if (response.status === "success") {
              // If it's a new event, add it to the calendar
              if (!self.$selectedEvent) {
                eventData.id = response.id;
                self.$calendarObj.addEvent(eventData);
              } else {
                // Update existing event
                self.$selectedEvent.remove();
                self.$calendarObj.addEvent(eventData);
              }
              self.$bootstrapModal.hide();
            } else {
              alert(
                "Failed to save event: " + (response.error || "Unknown error")
              );
            }
          },
          error: function (xhr, status, error) {
            console.error("Event save error:", error);
            console.error("Response text:", xhr.responseText);

            // Try to parse the error response
            try {
              var errorResponse = JSON.parse(xhr.responseText);
              alert("Failed to save event: " + (errorResponse.error || error));
            } catch (e) {
              alert("Failed to save event: " + error);
            }
          },
        });
      } else {
        form.classList.add("was-validated");
      }
    });

    // Delete event handler
    this.$btnDeleteEvent.on("click", function () {
      if (self.$selectedEvent) {
        // Confirm deletion
        if (!confirm("Are you sure you want to delete this event?")) {
          return;
        }

        l.ajax({
          url: "event-handler.php",
          method: "POST",
          data: {
            action: "delete",
            id: self.$selectedEvent.id,
          },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              // Remove event from calendar
              self.$selectedEvent.remove();

              // Hide the modal
              self.$bootstrapModal.hide();

              // Reset selected event
              self.$selectedEvent = null;
            } else {
              alert("Failed to delete event");
            }
          },
          error: function (xhr, status, error) {
            console.error("Event deletion error:", error);
            alert("Failed to delete event");
          },
        });
      }
    });
  };

  // Expose to global scope
  l.CalendarApp = new e();
  l.CalendarApp.Constructor = e;
})(window.jQuery);

// Initialize on document ready
jQuery(document).ready(function () {
  "use strict";
  window.jQuery.CalendarApp.init();
});
