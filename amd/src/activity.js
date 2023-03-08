/* eslint-disable */
import Templates from "core/templates";
import { exception as displayException } from "core/notification";

M.mod_tutoom = M.mod_tutoom || {};

export const init = (ID, isModerator, baseUrl) => {
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

  const renderTemplate = ({ data }) => {
    const element = document.getElementById("tutoom-main-section");

    Templates.renderForPromise("mod_tutoom/main_section", data)
      .then(({ html, js }) => {
        Templates.replaceNodeContents(element, html, js);
      })
      .catch((error) => displayException(error));
  };

  document.addEventListener("click", (e) => {
    const elementId = e.target.id;
    if (!elementId) return;

    if (elementId === "tutoom-start-button") startMeeting(e);
    if (elementId === "tutoom-end-button") endMeeting(e);
    if (elementId === "tutoom-join-button") joinMeeting(e);
    if (elementId === "tutoom-refresh-main-section") clearMainSection(e);
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
        const data = { error: true, errorcode: error.errorCode };
        renderTemplate({ data });
      }

      if (id) {
        const res = await getMeeting();
        const { meetingDate, participantsCount } = await res.json();

        const data = {
          meetingid: id,
          ismoderator: isModerator,
          meetingdate: meetingDate,
          participantscount: `${participantsCount}`,
          istextpluralparticipant: participantsCount > 1,
        };

        renderTemplate({ data });
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
      const { joinurl } = await fetch.json();

      if (!joinurl || joinurl === null) {
        const data = { error: true, meetingidnotexists: true };
        renderTemplate({ data });
      } else {
        window.location.href = joinurl;
      }
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

        if (error.meetingidnotexists) {
          const data = { error: true, meetingidnotexists: true };
          renderTemplate({ data });
        }
      }

      if (deleted) clearMainSection(e);
    } catch (error) {
      console.error(error);
    } finally {
      el.innerHTML = lastHTML;
    }
  };

  const clearMainSection = (e) => {
    e.preventDefault();

    const data = { meetingid: null, ismoderator: isModerator };
    renderTemplate({ data });
  };
};
