SELECT * FROM exam.media;

-- Add a new column
ALTER TABLE exam.resources
ADD COLUMN link text;

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

-- Function to generate a quiz for a given topic id and a given max limit
CREATE OR REPLACE FUNCTION exam.quiz (_max int, _topic_id int) 
RETURNS TABLE (
	question_id int,
    question_text varchar(255),
    option_one varchar(255),
    option_two varchar(255),
	option_three varchar(255),
	answer int
  )
as $$
begin
return QUERY 
SELECT q.question_id, q.question_text, q.option_one, q.option_two, q.option_three, q.answer
FROM exam.question q 
WHERE q.topic_id = _topic_id
ORDER BY random()
LIMIT _max;
end;
$$ language plpgsql;

-- Call function exam.quiz()
SELECT * FROM exam.quiz (3, 1)
