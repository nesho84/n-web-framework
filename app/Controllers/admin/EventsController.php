<?php

class EventsController extends Controller
{
    private EventsModel $eventsModel;

    //------------------------------------------------------------
    public function __construct()
    //------------------------------------------------------------
    {
        // Require Login
        Sessions::requireLogin();

        // Load Model
        $this->eventsModel = $this->loadModel("/admin/EventsModel");
    }

    //------------------------------------------------------------
    public function index(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Events';
        $data['theme'] = $_SESSION['settings']['settingTheme'] ?? "light";
        $data['rows'] = $this->eventsModel->getEvents('');

        $this->renderAdminView('/admin/events/events', $data);
    }

    //------------------------------------------------------------
    public function create_modal(): void
    //------------------------------------------------------------
    {
        $data['title'] = 'Event Create';

        $this->renderSimpleView('/admin/events/create_modal', $data);
    }

    //------------------------------------------------------------
    public function insert(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF(htmlspecialchars($_POST['csrf_token'] ?? ''));

        if (isset($_POST['create_event'])) {
            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'title' => htmlspecialchars(trim($_POST['title'])),
                'start' => htmlspecialchars(date('Y-m-d', strtotime($_POST['start']))),
                'end' => htmlspecialchars(date('Y-m-d', strtotime($_POST['end']))),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'url' => htmlspecialchars(trim($_POST['url'])),
            ];

            // Validate inputs
            $validator = new DataValidator();

            $validator('title', $postArray['title'])->required()->min(3)->max(20);
            $validator('start', $postArray['start'])->required();
            $validator('end', $postArray['end'])->required();

            if ($validator->isValidated()) {
                try {
                    // Insert in Database
                    $this->eventsModel->insertEvent($postArray);
                    setSessionAlert('success', 'Event created successfully');
                    redirect(ADMURL . '/events');
                } catch (Exception $e) {
                    setSessionAlert('error', $e->getMessage());
                    redirect(ADMURL . '/events');
                }
            } else {
                setSessionAlert('error', $validator->getErrors());
                redirect(ADMURL . '/events');
            }
        }
    }

    //------------------------------------------------------------
    public function eventsJson(): void
    //------------------------------------------------------------
    {
        $where_sql = '';
        $start = isset($_GET['start']) ? filter_var(trim($_GET['start']), FILTER_SANITIZE_SPECIAL_CHARS) : '';
        $end = isset($_GET['end']) ? filter_var(trim($_GET['end']), FILTER_SANITIZE_SPECIAL_CHARS) : '';
        if (!empty($start) && !empty($end)) {
            $where_sql .= " WHERE start BETWEEN '" . $start . "' AND '" . $end . "' ";
        }

        $data = $this->eventsModel->getEvents($where_sql);

        echo json_encode($data);
    }

    //------------------------------------------------------------
    public function insertJson(): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        // Retrieve JSON from POST body
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);

        if ($jsonObj->request_type == 'addEvent') {
            $start = $jsonObj->start;
            $end = $jsonObj->end;
            $event_data = $jsonObj->event_data;
            $eventTitle = !empty($event_data[0]) ? $event_data[0] : '';
            $eventDesc = !empty($event_data[1]) ? $event_data[1] : '';
            $eventURL = !empty($event_data[2]) ? $event_data[2] : '';

            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'start' => htmlspecialchars($start),
                'end' => htmlspecialchars($end),
                'title' => htmlspecialchars($eventTitle),
                'description' => htmlspecialchars($eventDesc),
                'url' => htmlspecialchars($eventURL),
            ];

            // Validate inputs
            $validator = new DataValidator();

            $validator('Title', $postArray['title'])->required()->min(3)->max(20);
            $validator('Start', $postArray['start'])->required();
            $validator('End', $postArray['end'])->required();

            if ($validator->isValidated()) {
                try {
                    // Insert in Database
                    $this->eventsModel->insertEvent($postArray);
                    echo json_encode([
                        "status" => "success",
                        'message' => 'Event created successfully',
                    ]);
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode([
                        "status" => "error",
                        "message" => $e->getMessage()
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => $validator->getErrors()
                ]);
                exit;
            }
        }
    }

    //------------------------------------------------------------
    public function deleteJson(int $id): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        // Retrieve JSON from POST body
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);

        if ($jsonObj->request_type == 'deleteEvent') {
            $id = htmlspecialchars($jsonObj->event_id);

            try {
                // Delete in Database
                $this->eventsModel->deleteEvent($id);
                echo json_encode([
                    "status" => "success",
                    'message' => 'Event deleted successfully',
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "status" => "error",
                    "message" => $e->getMessage()
                ]);
                exit;
            }
        }
    }

    //------------------------------------------------------------
    public function updateJson(int $id): void
    //------------------------------------------------------------
    {
        // Set Security Headers and Require CSRF_TOKEN
        Sessions::setHeaders()->requireCSRF();

        // Retrieve JSON from POST body
        $jsonStr = file_get_contents('php://input');
        $jsonObj = json_decode($jsonStr);

        if ($jsonObj->request_type == 'editEvent') {
            $event_id = $jsonObj->event_id;
            $start = $jsonObj->start;
            $end = $jsonObj->end;

            $event_data = $jsonObj->event_data;
            $eventTitle = !empty($event_data[0]) ? $event_data[0] : '';
            $eventDesc = !empty($event_data[1]) ? $event_data[1] : '';
            $eventURL = !empty($event_data[2]) ? $event_data[2] : '';

            $postArray = [
                'userID' => $_SESSION['user']['id'],
                'id' => htmlspecialchars($event_id),
                'start' => htmlspecialchars($start),
                'end' => htmlspecialchars($end),
                'title' => htmlspecialchars($eventTitle),
                'description' => htmlspecialchars($eventDesc),
                'url' => htmlspecialchars($eventURL),
            ];

            // Get existing event from the Model
            $event = $this->eventsModel->getEventById($id);

            // Validate inputs
            $validator = new DataValidator();

            $validator('Title', $postArray['title'])->required()->min(3)->max(20);
            $validator('Start', $postArray['start'])->required();
            $validator('End', $postArray['end'])->required();

            if ($validator->isValidated()) {
                // Remove unchanged postArray keys but keep the 'id'
                foreach ($postArray as $key => $value) {
                    if (isset($postArray[$key]) && $event[$key] == $value && $key !== 'id') {
                        unset($postArray[$key]);
                    }
                }
                // remove empty keys
                $postArray = array_filter($postArray, 'strlen');

                if (count($postArray) > 1) {
                    try {
                        // Update in Database
                        $this->eventsModel->updateEvent($postArray);
                        echo json_encode([
                            "status" => "success",
                            'message' => 'Event updated successfully',
                        ]);
                    } catch (Exception $e) {
                        http_response_code(500);
                        echo json_encode([
                            "status" => "error",
                            "message" => $e->getMessage()
                        ]);
                        exit;
                    }
                } else {
                    echo json_encode([
                        "status" => "warning",
                        "message" => 'No fields were changed'
                    ]);
                    exit;
                }
            } else {
                // http_response_code(422);
                echo json_encode([
                    "status" => "error",
                    "message" => $validator->getErrors()
                ]);
                exit;
            }
        }
    }
}
