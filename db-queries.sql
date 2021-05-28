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

-- Creating a view for all topics and user topic log related data (updated)
CREATE VIEW exam.user_log_view AS
SELECT 
	"user".user_id,
	topic.topic_id, topic.name, topic.body,
	user_topic_log.seen AS topic_seen, user_topic_log.quiz_passed
FROM 
	exam.topic FULL JOIN exam.user_topic_log ON topic.topic_id = user_topic_log.topic_id
	FULL JOIN exam.user ON "user".user_id = user_topic_log.user_id;	

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

-- Stored procedure that didn't work
CREATE OR REPLACE PROCEDURE exam.add_user_log (
_user_id int,
_topic_id int,
_quiz_passed boolean)
LANGUAGE plpgsql
AS $$
DECLARE
did_insert boolean := false;
exists_id boolean;
BEGIN
SELECT EXISTS(SELECT 1 FROM exam.user_topic_log WHERE  user_id=_user_id AND topic_id=_topic_id) INTO exists_id;

IF exists_id IS FALSE THEN
INSERT INTO exam.user_topic_log (user_id, topic_id, seen, quiz_passed) VALUES (_user_id, _topic_id, true, _quiz_passed)
RETURNING exists_id = true;

ELSE 
UPDATE exam.user_topic_log
SET seen = true,
    quiz_passed = _quiz_passed
WHERE user_id = _user_id AND topic_id = _topic_id;
END if;

END;
$$;

-- Stored procedure that works
CREATE OR REPLACE PROCEDURE exam.add_user_log (
_user_id int,
_topic_id int,
_quiz_passed boolean)
LANGUAGE plpgsql
AS $$
BEGIN
   IF EXISTS(SELECT 1 FROM exam.user_topic_log WHERE user_id=_user_id AND topic_id=_topic_id) 
      THEN
      UPDATE exam.user_topic_log
      SET seen = true,
      quiz_passed = _quiz_passed
      WHERE user_id = _user_id AND topic_id = _topic_id;
   ELSE 
   INSERT INTO exam.user_topic_log(user_id, topic_id, seen, quiz_passed) 
   VALUES(_user_id, _topic_id, true, _quiz_passed);
   END if;
END;
$$;

-- Stored procedure - insert new resource in the db
CREATE OR REPLACE PROCEDURE exam.post_resources(
	_user_id integer, 
	_topic_id integer, 
	_creation_date TIMESTAMP,
	_resources_text text, 
	_link text)
LANGUAGE plpgsql
AS $$
BEGIN
INSERT INTO exam.resources(resource_id, user_id, topic_id, creation_date, resources_text, votes, link) VALUES (DEFAULT, _user_id, _topic_id, _creation_date, _resources_text, 1, _link);
END;
$$;

-- Stored procedure - Insert old data into the log
CREATE OR REPLACE FUNCTION exam.log_user() 
RETURNS trigger
AS $$
DECLARE
BEGIN
  INSERT INTO exam.user_update_logs (user_id, old_first_name, old_last_name, old_email)
  VALUES (OLD.user_id, OLD.first_name, OLD.last_name, OLD.email);
  RAISE NOTICE 'User information has been updated #%', OLD.user_id;
  RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Trigger - log changes after a row is updates
CREATE TRIGGER log_users
AFTER UPDATE ON exam.user
FOR EACH ROW EXECUTE PROCEDURE exam.log_user();

-- Update a row
UPDATE exam.user 
SET first_name ='Iulia'
WHERE user_id = 3;

