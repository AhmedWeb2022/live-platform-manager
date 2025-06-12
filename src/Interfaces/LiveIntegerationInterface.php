<?php

namespace ahmedWeb\LivePlatformManager\Interfaces;

/**
 * Interface LiveIntegerationInterface
 *
 * Defines the contract for integrating live session functionality, including creating, storing, and joining sessions.
 */
interface LiveIntegerationInterface
{
    /**
     * Create a live session.
     *
     * @param array $data An associative array containing the necessary details for creating a live session.
     * @return mixed The result of the live session creation process, typically a response or status.
     */
    public function create_live(array $data);

    /**
     * Store live session data.
     *
     * @param array $data An associative array containing the details to store a live session.
     * @return mixed The result of storing the live session, such as a confirmation or ID.
     */
    public function store_live(array $data);

    /**
     * Join an existing live session.
     *
     * @param array $data An associative array containing the necessary details to join a live session.
     * @return mixed The result of the join operation, such as a redirection URL or status.
     */
    public function join_live(array $data);

    /**
     * Prepare the request body for live session operations.
     *
     * @param array $body An associative array of raw data to be formatted for a live session request.
     * @return array The prepared request body formatted for the live session platform.
     */
    public function prepare_body(array $body);
}
