/* eslint-disable */

import {
  clearMainSection,
  endMeeting,
  joinMeeting,
  startMeeting,
} from "./meeting";
import { getRecordings } from "./recording";

M.mod_tutoom = M.mod_tutoom || {};

export const init = (params) => {
  window.tutoom = params;

  const { showRecordings } = params;

  document.addEventListener("click", async (e) => {
    const elementName = e.target.name;
    const elementId = e.target.id;

    if (elementId) {
      if (elementId === "tutoom-start-button") startMeeting(e);
      if (elementId === "tutoom-end-button") endMeeting(e);
      if (elementId === "tutoom-join-button") joinMeeting(e);
      if (elementId === "tutoom-refresh-main-section") clearMainSection(e);

      if (elementId === "tutoom-recordings-btn-previous") {
        const classNames = e.target.className;
        if (classNames.includes("disabled")) {
          e.preventDefault();
        } else {
          const currentPage = document.getElementById(
            "tutoom-recordings-current-page"
          ).value;

          await getRecordings({ page: parseInt(currentPage) - 1 });
        }
      }

      if (elementId === "tutoom-recordings-btn-next") {
        const classNames = e.target.className;
        if (classNames.includes("disabled")) {
          e.preventDefault();
        } else {
          const currentPage = document.getElementById(
            "tutoom-recordings-current-page"
          ).value;

          await getRecordings({ page: parseInt(currentPage) + 1 });
        }
      }
    }

    if (elementName) {
      if (elementName === "btn-page") {
        const page = parseInt(e.target.value);
        const currentPage = parseInt(
          document.getElementById("tutoom-recordings-current-page").value
        );

        if (currentPage === page) {
          e.preventDefault();
          return;
        }

        await getRecordings({ page });
      }
    }
  });

  setTimeout(async () => {
    if (showRecordings) {
      const { countRecordings } = params;
      if (countRecordings > 0) {
        await getRecordings({ page: 1, isFirstTime: true });
      }
    }
  }, 1);
};
