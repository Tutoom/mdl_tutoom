/* eslint-disable */

import { ACTIONS_AJAX_RECORDING } from "./lib/actions";
import { TEMPLATES, renderTemplate } from "./lib/template";

M.mod_tutoom = M.mod_tutoom || {};

export const joinPlayback = async (e) => {
  e.preventDefault();

  const tutoom = window.tutoom;
  if (!tutoom || tutoom === undefined) throw new Error("Tutoom data is empty");

  const { baseUrl, id: ID } = tutoom;

  const { meetingid } = e.target.dataset;

  try {
    const url = `${baseUrl}?action=${ACTIONS_AJAX_RECORDING.JOIN_PLAYBACK}&sesskey=${M.cfg.sesskey}&id=${ID}&meetingId=${meetingid}`;
    const fetch = await window.fetch(url);
    const { joinurl } = await fetch.json();

    window.location.href = joinurl;
  } catch (error) {
    console.error(error);
  }
};

export const getRecordings = async ({ page = 1, isFirstTime = false }) => {
  const tutoom = window.tutoom;
  if (!tutoom || tutoom === undefined) throw new Error("Tutoom data is empty");

  const { baseUrl, id: ID, countRecordings, limitRecordings } = tutoom;

  const elementRecordingTableContent = document.getElementById(
    "tutoom-recordings-table-content"
  );
  const elementRecordingLoader = document.getElementById(
    "tutoom_view_recordings_loading"
  );

  try {
    // Show loader recordings.
    if (!isFirstTime) {
      elementRecordingTableContent.innerHTML = "";
      elementRecordingLoader.style.display = "flex";
    }

    const url = `${baseUrl}?action=${ACTIONS_AJAX_RECORDING.GET_RECORDINGS}&sesskey=${M.cfg.sesskey}&id=${ID}&page=${page}`;
    const fetch = await window.fetch(url);
    const { data } = await fetch.json();

    const recordings = data.map((r, index) => {
      const isLastIndex = index === data.length - 1;
      const renderRowSeparator = !isLastIndex;
      const { RecordingId, Duration, CreationTimestamp, MeetingId, Thumbnail } =
        r;

      const language = window.navigator.language;

      const seconds = Duration;
      const hours = Math.floor(seconds / 3600);
      const minutes = Math.floor((seconds % 3600) / 60) + "min";

      const duration = hours > 0 ? `${hours}h ${minutes}` : minutes;

      const date = new Date(CreationTimestamp).toLocaleString(language, {
        month: "short",
        day: "numeric",
        year: "numeric",
      });
      const time = new Date(CreationTimestamp).toLocaleString(language, {
        hour: "numeric",
        minute: "numeric",
        hour12: true,
      });

      return {
        recordingId: RecordingId,
        thumbnail: Thumbnail,
        duration,
        date,
        time,
        renderRowSeparator,
        meetingid: MeetingId,
      };
    });

    const callbackBeforeRender = () => {
      elementRecordingLoader.style.display = "none";
    };

    const callbackAfterRender = () => {
      const thumbnails = document.querySelectorAll(".thumbnail");
      thumbnails.forEach((thumbnail) => {
        thumbnail.addEventListener("click", joinPlayback);
      });
    };

    await renderTemplate({
      data: { recordings },
      type: TEMPLATES.RECORDING_TABLE_CONTENT,
      callbackBeforeRender,
      callbackAfterRender,
    });

    const totalPages = Math.ceil(countRecordings / limitRecordings);
    const pages = [...Array(totalPages).keys()].map((n) => ({
      number: n + 1,
      isSelected: n + 1 === page,
    }));

    const currentPage = pages.findIndex((p) => p.isSelected) + 1;

    if (totalPages > 1) {
      const dataPagination = {
        pages,
        disablePrevious: page === 1,
        disableNext: page === totalPages,
        currentPage,
      };

      renderTemplate({
        data: dataPagination,
        type: TEMPLATES.RECORDING_PAGINATION,
      });
    }
  } catch (error) {
    console.error(error);
  }
};
