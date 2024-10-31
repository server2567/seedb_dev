<style>
    .ui-state-highlight {
        height: 3em;
        line-height: 3em;
        background-color: #f0f0f0;
        border: 1px dashed #ccc;
    }

    /* scroll bar x */
    .scroll-x-container {
        display: flex;
        overflow-x: auto;
        white-space: nowrap;
        overflow-y: auto;
        height: 1000px;
    }

    .scrollbar-top-container {
        height: 20px;
        overflow-x: auto;
        overflow-y: hidden;
    }

    .scrollbar-top {
        height: 100%;
        width: 100%; /* This will be set dynamically based on content */
    }

    /* container-que */
    .container-que .card-header {
        display: flex;
        justify-content: space-between;
    }

    /* spin loading */
    .spinner-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent background */
        z-index: 10; /* Ensure it overlays the content */
        display: flex;
    }

    /* .container-que .card-header .patient-count {
        font-size: 16px;
        font-weight: bold;
    } */

    .container-que .col-md-4 {
        flex: 0 0 auto; /* Prevent flex items from shrinking or growing */
        width: 300px; /* Adjust the width as needed */
    }

    .sortable-list {
        min-height: 50px; /* Ensure a minimum height for empty lists */
        padding: 10px;
        border: 2px dashed transparent; /* Initially transparent border */
    }

    .sortable-list.empty {
        /* border-color: #007bff; */
        margin-bottom: 10px;
        background-color: #e2e3e5;
    }

    .sortable-item {
        /* border: 2px dashed #007bff; */
        padding: 10px; /* Adjust padding */
        position: relative;
        box-shadow: 0px 0 30px rgba(1, 41, 112, 0.1);
        white-space: normal;
    }

    /* Styling for the task number */
    .task-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .task-header .que-text, .task-header .order-number {
        font-size: 16px;
        font-weight: bold;
    }

    /* Flex container for status text and buttons */
    .task-body {
        /* display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100px;  */
        /* Adjust height if necessary */

        font-size: 14px;
        /* margin-bottom: 10px; */
        display: flex;
        justify-content: space-between;
    }

    /* Styling for the status text */
    /* .status-text {
        font-size: 14px;
    } */

    /* Flex container for status and urgency */
    /* .task-status {
        white-space: pre-wrap;
    } */

    /* Styling for the urgent text */
    /* .urgent {
        font-size: 14px;
        font-weight: bold;
    } */

    /* Flex container for the buttons */
    /* .task-buttons {
        display: flex;
        justify-content: space-between;
    } */

    /* Styling for the buttons */
    /* .task-btn {
        width: 20px;
        height: 20px;
        background-color: #ccc;
        border: none;
        border-radius: 3px; 
    } */


     /* Footer buntton styling */
    .footer-actions {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: #f8f9fa; /* Light background color */
        border-top: 1px solid #ddd; /* Top border to separate from content */
        padding: 10px 20px;
        display: flex;
        justify-content: flex-end; /* Align buttons to the right */
        box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1); /* Add a slight shadow */
    }

     /* Room */
    .room-name-text:hover {
        cursor: pointer;
    }

    .task-body {
  font-size: 16px !important;
  line-height: 1.7;
  cursor: all-scroll;
}

.task-buttons {
  border-top: 1px solid #999;
  padding-top: 10px;
  margin-top: 10px;
  display:flex;
  justify-content: end;
}
</style>