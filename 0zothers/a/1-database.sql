CREATE TABLE `gps_track` (
  `rider_id` bigint(20) NOT NULL,
  `track_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `track_lng` decimal(11,7) NOT NULL,
  `track_lat` decimal(11,7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `gps_track`
  ADD PRIMARY KEY (`rider_id`),
  ADD KEY `track_time` (`track_time`);