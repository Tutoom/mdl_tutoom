/* eslint-disable */

import Templates from "core/templates";
import notification from "core/notification";

export const TEMPLATES = {
  MAIN_SECTION: "mod_tutoom/main_section",
  RECORDING_TABLE_CONTENT: "mod_tutoom/recordings_table_content",
  RECORDING_PAGINATION: "mod_tutoom/recordings_pagination",
};

/**
 *
 * @param {{data: any, type: string, callbackBeforeRender?: any, callbackAfterRender?: any}} params
 */
export const renderTemplate = async ({
  data,
  type,
  callbackBeforeRender,
  callbackAfterRender,
}) => {
  let el = null;
  const elementMainSection = document.getElementById("tutoom-main-section");
  const elementRecordingTableContent = document.getElementById(
    "tutoom-recordings-table-content"
  );
  const elementPagination = document.getElementById(
    "tutoom_view_recordings_pagination"
  );

  if (type === TEMPLATES.MAIN_SECTION) el = elementMainSection;
  if (type === TEMPLATES.RECORDING_TABLE_CONTENT)
    el = elementRecordingTableContent;
  if (type === TEMPLATES.RECORDING_PAGINATION) el = elementPagination;

  if (el) {
    return Templates.renderForPromise(type, data)
      .then(({ html, js }) => {
        callbackBeforeRender && callbackBeforeRender();

        Templates.replaceNodeContents(el, html, js);

        callbackAfterRender && callbackAfterRender();
      })
      .catch((error) => {
        notification.addNotification({
          message: JSON.stringify(error),
          type: "error",
        });
      });
  } else {
    notification.addNotification({
      message: `Error while render a template: ${template}`,
      type: "error",
    });
  }
};
