SELECT * FROM exam.media;

-- Creating a view for all resources related data
CREATE VIEW exam.resources_view AS
SELECT 
resources.resource_id, resources.creation_date, 
resources.resources_text AS body, 
resources.votes, resources.link,
topic.topic_id, topic.name AS topic_name, 
"user".first_name AS user_name, "user".last_name AS user_last_name
FROM exam.resources JOIN exam.topic ON resources.topic_id = topic.topic_id 
JOIN exam.user ON resources.user_id = "user".user_id
ORDER BY resources.votes DESC;


-- Creating a view for all topics and user topic log related data
CREATE VIEW exam.user_log_view AS
SELECT 
	topic.topic_id, topic.name, topic.body, user_topic_log.user_id,
	user_topic_log.seen AS topic_seen, user_topic_log.quiz_passed
FROM exam.topic FULL JOIN exam.user_topic_log ON topic.topic_id = user_topic_log.topic_id;	

-- Creating topics view including media, src and metadata
CREATE VIEW exam.topic_view AS
SELECT 
	topic.topic_id, topic.name, topic.body,
	media.media_id, media.metadata_id,
	src.src_id, src.src_desktop, src.src_mobile,
	metadata.description AS meta_description, metadata.tag AS meta_tag, metadata.author AS meta_author
FROM exam.topic FULL JOIN exam.media ON topic.topic_id = media.topic_id
	FULL JOIN exam.src ON media.src_id = src.src_id
	FULL JOIN exam.metadata ON metadata.metadata_id = media.metadata_id;