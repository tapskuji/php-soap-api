<?php

function getData()
{
    $file = __DIR__ . '/data.json';
    if (!is_readable($file)) {
        file_put_contents($file, json_encode(array(), JSON_PRETTY_PRINT));
        chmod($file, 0666);
    }
    return json_decode(file_get_contents($file), true);
}

function saveData($tasks)
{
    $file = __DIR__ . '/data.json';
    return file_put_contents($file, json_encode($tasks, JSON_PRETTY_PRINT));
}

function createTask($task)
{
    $tasks = getData();
    if (count($tasks) !== 0) {
        $lastTaskId = $tasks[count($tasks) - 1]['id'];
        $id = $lastTaskId + 1;
    } else {
        $id = 1;
    }

    $newTask['id'] = $id;
    $newTask['title'] = $task['title'];
    $newTask['description'] = $task['description'];
    $newTask['deadline'] = $task['deadline'];
    $newTask['isComplete'] = (bool)$task['isComplete'];
    $newTask['subtasks'] = [];

    $count = 0;
    foreach ($task['subtasks'] as $subtask) {
        $newSubtask['id'] = ++$count;
        $newSubtask['task_id'] = $id;
        $newSubtask['title'] = $subtask['title'];
        $newSubtask['description'] = $subtask['description'];
        $newSubtask['deadline'] = $subtask['deadline'];
        $newSubtask['isComplete'] = (bool)$subtask['isComplete'];;

        $newTask['subtasks'][] = $newSubtask;
    }

    $tasks[] = $newTask;
    saveData($tasks);
    return array(
        'status' => 'success',
        'message' => "",
        'results' => array(),
    );
}

function updateTask($task)
{
    $tasks = getData();
    $found = false;
    foreach ($tasks as $index => $oldTask) {
        if ($oldTask['id'] == $task['id']) {
            $found = true;
            $tasks[$index]['title'] = $task['title'];
            $tasks[$index]['description'] = $task['description'];
            $tasks[$index]['deadline'] = $task['deadline'];
            $tasks[$index]['isComplete'] = (bool)$task['isComplete'];

            saveData($tasks);
            return array(
                'status' => 'success',
                'message' => "",
                'results' => array(),
            );
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Task not found",
        'results' => array(),
    );
}

function getTask($id)
{
    $tasks = getData();
    foreach ($tasks as $task) {
        if ($task['id'] == $id) {
            return array(
                'status' => 'success',
                'message' => "",
                'results' => array($task),
            );
        }
    }
    return array(
        'status' => 'failed',
        'message' => "Task not found",
        'results' => array(),
    );
}

function getTasks()
{
    $tasks = getData();
    return array(
        'status' => 'success',
        'message' => "",
        'results' => $tasks,
    );
}

function deleteTask($id)
{
    $tasks = getData();
    $count = count($tasks);
    $tasks = array_filter($tasks, function ($task) use (&$id) {
        return $task['id'] !== $id;
    });

    if (count($tasks) === $count) {
        return array(
            'status' => 'failed',
            'message' => "Task not found",
            'results' => array(),
        );
    }

    $tasks = array_values($tasks);
    saveData($tasks);
    return array(
        'status' => 'success',
        'message' => "",
        'results' => array(),
    );
}

function createSubtask($subtask)
{
    $tasks = getData();

    foreach ($tasks as $index => $task) {
        if ($task['id'] == $subtask['task_id']) {
            if (count($task['subtasks']) !== 0) {
                $lastSubtaskId = $task['subtasks'][count($task['subtasks']) - 1]['id'];
                $id = $lastSubtaskId + 1;
            } else {
                $id = 1;
            }

            $newSubtask['id'] = $id;
            $newSubtask['task_id'] = $subtask['task_id'];
            $newSubtask['title'] = $subtask['title'];
            $newSubtask['description'] = $subtask['description'];
            $newSubtask['deadline'] = $subtask['deadline'];
            $newSubtask['isComplete'] = (bool)$subtask['isComplete'];

            $tasks[$index]['subtasks'][] = $newSubtask;

            saveData($tasks);
            return array(
                'status' => 'success',
                'message' => "",
                'results' => array(),
            );
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Task not found",
        'results' => array(),
    );
}

function updateSubtask($subtask)
{
    $tasks = getData();

    foreach ($tasks as $index => $task) {
        if ($task['id'] == $subtask['task_id']) {
            foreach ($task['subtasks'] as $subtaskIndex => $currentSubtask) {
                if ($currentSubtask['id'] == $subtask['id']) {
                    $tasks[$index]['subtasks'][$subtaskIndex]['title'] = $subtask['title'];
                    $tasks[$index]['subtasks'][$subtaskIndex]['description'] = $subtask['description'];
                    $tasks[$index]['subtasks'][$subtaskIndex]['deadline'] = $subtask['deadline'];
                    $tasks[$index]['subtasks'][$subtaskIndex]['isComplete'] = (bool)$subtask['isComplete'];

                    saveData($tasks);
                    return array(
                        'status' => 'success',
                        'message' => "",
                        'results' => array(),
                    );
                }
            }
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Task not found",
        'results' => array(),
    );
}

function getSubtask($id, $task_id)
{
    $tasks = getData();

    foreach ($tasks as $index => $task) {
        if ($task['id'] == $task_id) {
            foreach ($task['subtasks'] as $subtaskIndex => $currentSubtask) {
                if ($currentSubtask['id'] == $id) {
                    return array(
                        'status' => 'success',
                        'message' => "",
                        'results' => array($currentSubtask),
                    );
                }
            }
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Subtask not found",
        'results' => array(),
    );
}

function getSubtasks($task_id)
{
    $tasks = getData();

    foreach ($tasks as $index => $task) {
        if ($task['id'] == $task_id) {
            return array(
                'status' => 'success',
                'message' => "",
                'results' => $task['subtasks'],
            );
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Subtask not found",
        'results' => array(),
    );
}

function deleteSubtask($id, $task_id)
{
    $tasks = getData();

    foreach ($tasks as $index => $task) {
        if ($task['id'] == $task_id) {
            foreach ($task['subtasks'] as $subtaskIndex => $currentSubtask) {
                if ($currentSubtask['id'] == $id) {
                    unset($tasks[$index]['subtasks'][$subtaskIndex]);
                    $subtasks = array_values($tasks[$index]['subtasks']);
                    $tasks[$index]['subtasks'] = $subtasks;

                    saveData($tasks);
                    return array(
                        'status' => 'success',
                        'message' => "",
                        'results' => array(),
                    );
                }
            }
        }
    }

    return array(
        'status' => 'failed',
        'message' => "Subtask not found",
        'results' => array(),
    );
}
