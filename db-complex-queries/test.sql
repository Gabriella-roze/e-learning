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


