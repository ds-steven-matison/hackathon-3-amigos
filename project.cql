CREATE KEYSPACE IF NOT EXISTS "biometrics" 
  WITH REPLICATION = {
    'class' : 'SimpleStrategy',
    'replication_factor' : 1
  }
AND DURABLE_WRITES = true; 
USE "biometrics";
CREATE TABLE IF NOT EXISTS "biometrics"."biometrics_by_voter" (
  "voter_uuid" uuid,
  "face_photo_1" text,
  "face_photo_2" text,
  "face_photo_3" text,
  "fingerprint_left_pinky" text,
  "fingerprint_left_ring" text,
  "fingerprint_left_middle" text,
  "fingerprint_left_index" text,
  "fingerprint_left_thumb" text,
  "fingerprint_right_thumb" text,
  "fingerprint_right_index" text,
  "fingerprint_right_middle" text,
  "fingerprint_right_ring" text,
  "fingerprint_right_pinky" text,
  "signature" text,
  "updated_ts" timestamp,
  PRIMARY KEY ("voter_uuid")
);