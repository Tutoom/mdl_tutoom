/* eslint-disable */
import Templates from "core/templates";
import { exception as displayException } from "core/notification";

M.mod_tutoom = M.mod_tutoom || {};

export const init = (ID, isModerator) => {
  const baseUrl = "/moodle/mod/tutoom/tutoom_ajax.php";
  const contentContainer = document.getElementById("tutoom-content-box");
  const spinnerHTML =
    "<div class='spinner-border spinner-border-sm text-dark'></div>";

  const ACTIONS = {
    GET_MEETING: "get_meeting",
    START_MEETING: "start_meeting",
    JOIN_MEETING: "join_meeting",
    END_MEETING: "end_meeting",
    GET_RECORDINGS: "get_recordings",
  };

  const getMeeting = async () => {
    const url = `${baseUrl}?action=${ACTIONS.GET_MEETING}&sesskey=${M.cfg.sesskey}&id=${ID}`;
    return await window.fetch(url);
  };

  document.addEventListener("click", (e) => {
    const elementId = e.target.id;
    if (!elementId) return;

    if (elementId === "tutoom-start-button") startMeeting(e);
    if (elementId === "tutoom-end-button") endMeeting(e);
    if (elementId === "tutoom-join-button") joinMeeting(e);
  });

  const startMeeting = async (e) => {
    e.preventDefault();

    const el = document.getElementById("tutoom-start-button");
    const widthButton = el.offsetWidth;
    const lastHTML = el.innerHTML;

    el.style.width = `${widthButton}px`;
    el.innerHTML = spinnerHTML;

    try {
      const url = `${baseUrl}?action=${ACTIONS.START_MEETING}&sesskey=${M.cfg.sesskey}&id=${ID}&logoutUrl=${window.location.href}`;
      const fetch = await window.fetch(url);
      const response = await fetch.json();

      const { error, id } = response;

      if (error) {
        console.error(error);
      }

      if (id) {
        const res = await getMeeting();
        const { creationTimestamp, participantsCount } = await res.json();

        let meetingDate = new Date(creationTimestamp._seconds * 1000);
        meetingDate = meetingDate.toLocaleTimeString(navigator.language, {
          hour: "2-digit",
          minute: "2-digit",
        });

        Templates.renderForPromise("mod_tutoom/main_section", {
          meetingid: id,
          role: isModerator,
          meetingdate: meetingDate,
          participantscount: `${participantsCount}`,
          istextpluralparticipant: participantsCount > 1,
        })
          .then(({ html, js }) => {
            Templates.replaceNodeContents(contentContainer, html, js);
          })
          .catch((error) => displayException(error));
      }
    } catch (error) {
      console.error(error);
      el.innerHTML = lastHTML;
    }
  };

  const joinMeeting = async (e) => {
    e.preventDefault();

    const el = document.getElementById("tutoom-join-button");
    const widthButton = el.offsetWidth;
    const lastHTML = el.innerHTML;

    el.style.width = `${widthButton}px`;
    el.innerHTML = spinnerHTML;

    try {
      const url = `${baseUrl}?action=${ACTIONS.JOIN_MEETING}&sesskey=${M.cfg.sesskey}&id=${ID}`;
      const fetch = await window.fetch(url);
      const response = await fetch.json();
      window.location.href = response;
    } catch (error) {
      console.error(error);
    } finally {
      el.innerHTML = lastHTML;
    }
  };

  const endMeeting = async (e) => {
    e.preventDefault();

    const value = e.target.value;

    const el = document.getElementById("tutoom-end-button");
    const widthButton = el.offsetWidth;
    const lastHTML = el.innerHTML;

    el.style.width = `${widthButton}px`;
    el.innerHTML = `<div class='spinner-border spinner-border-sm text-danger'></div>`;

    try {
      const url = `${baseUrl}?action=${ACTIONS.END_MEETING}&sesskey=${M.cfg.sesskey}&id=${ID}&meetingId=${value}`;
      const fetch = await window.fetch(url);
      const response = await fetch.json();

      const { error, deleted } = response;

      if (error) {
        console.error(error);
      }

      if (deleted) {
        Templates.renderForPromise("mod_tutoom/main_section", {
          meetingid: null,
          role: isModerator,
        })
          .then(({ html, js }) => {
            Templates.replaceNodeContents(contentContainer, html, js);
          })
          .catch((error) => displayException(error));
      }
    } catch (error) {
      console.error(error);
    } finally {
      el.innerHTML = lastHTML;
    }
  };
};
