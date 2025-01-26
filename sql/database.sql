--
-- Trigger triggerdate()
--

CREATE OR REPLACE FUNCTION public.triggerdate() RETURNS TRIGGER
	LANGUAGE PLPGSQL
	AS $$
BEGIN
	IF (SELECT (OLD.date_start, OLD.date_end) OVERLAPS (NEW.date_start, NEW.date_end)) THEN
		RETURN OLD;
	END IF;
	RETURN NEW;
END; $$;

--
-- Trigger triggeruser()
--

CREATE OR REPLACE FUNCTION public.triggeruser() RETURNS TRIGGER
	LANGUAGE PLPGSQL
	AS $$
BEGIN
	INSERT INTO user_role (uid_user) VALUES (NEW.uid);
	RETURN NEW;
END; $$;

--
-- Trigger triggerdateupdate()
--

CREATE OR REPLACE FUNCTION public.triggerdateupdate() RETURNS TRIGGER
	LANGUAGE PLPGSQL
	AS $$
BEGIN
	NEW.date_update = CURRENT_TIMESTAMP;
	RETURN NEW;
END; $$;

--
-- Trigger triggerdeleterefused()
--

CREATE OR REPLACE FUNCTION public.triggerdeleterefused() RETURNS TRIGGER
	LANGUAGE PLPGSQL
	AS $$
BEGIN
	IF NEW.id_state = 3 THEN
		DELETE FROM public.reservations WHERE uid = NEW.uid;
		RETURN NULL;
	END IF;
	RETURN NEW;
END; $$;

--
-- Table structure for table 'disponibilities'
--

CREATE TABLE public.disponibilities (
	uid CHARACTER VARYING(32) NOT NULL,
	uid_user CHARACTER VARYING(32) NOT NULL,
	date_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	date_end TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Table structure for table 'groups'
--

CREATE TABLE public.groups (
	uid CHARACTER VARYING(32) NOT NULL,
	name CHARACTER VARYING(64) NOT NULL
);

--
-- Table structure for table 'reservations'
--

CREATE TABLE public.reservations (
	uid CHARACTER VARYING(32) NOT NULL,
	uid_teacher CHARACTER VARYING(32) NOT NULL,
	uid_student CHARACTER VARYING(32) NOT NULL,
	date_start TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT null,
	date_end TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT null,
	uid_disponibilities CHARACTER VARYING(32) ,
	id_type INTEGER NOT NULL DEFAULT 1,
	id_reason INTEGER NOT NULL DEFAULT 1,
	id_state INTEGER NOT NULL DEFAULT 1,
	comment TEXT NULL,
	date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Table structure for table 'types'
--

CREATE TABLE public.types (
	id INTEGER NOT NULL,
	name CHARACTER VARYING(64) NOT NULL
);

--
-- Table structure for table 'reasons'
--

CREATE TABLE public.reasons (
	id INTEGER NOT NULL,
	name CHARACTER VARYING(64) NOT NULL
);

--
-- Table structure for table 'states'
--

CREATE TABLE public.states (
	id INTEGER NOT NULL,
	name CHARACTER VARYING(64) NOT NULL
);

--
-- Table structure for table 'roles'
--

CREATE TABLE public.roles (
	id INTEGER NOT NULL,
	name CHARACTER VARYING(64) NOT NULL
);

--
-- Table structure for table 'tutoring'
--

CREATE TABLE public.tutoring (
	uid_student CHARACTER VARYING(32) NOT NULL,
	uid_teacher CHARACTER VARYING(32) NOT NULL,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Table structure for table 'users'
--

CREATE TABLE public.users (
	uid CHARACTER VARYING(32) NOT NULL,
	name CHARACTER VARYING(255) NOT NULL,
	surname CHARACTER VARYING(255) NOT NULL,
	email CHARACTER VARYING(255) NOT NULL,
	password CHARACTER VARYING(128) NOT NULL,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	date_create TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Table structure for table 'user_group'
--

CREATE TABLE public.user_group (
	uid_user CHARACTER VARYING(32) NOT NULL,
	uid_group CHARACTER VARYING(32) NOT NULL,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Table structure for table 'user_role'
--

CREATE TABLE public.user_role (
	uid_user CHARACTER VARYING(32) NOT NULL,
	id_role INTEGER NOT NULL DEFAULT 1,
	date_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

--
-- Data for table 'roles'
--

INSERT INTO public.roles (id, name) VALUES (1, 'student'), (2, 'teacher'), (10, 'administrator');

--
-- Data for table 'types'
--

INSERT INTO public.types (id, name) VALUES (1, 'visit'), (2, 'face to face'), (3, 'phone'), (4, 'video discord'), (5, 'video teams');

--
-- Data for table 'reasons'
--

INSERT INTO public.reasons (id, name) VALUES (1, 'review 1'), (2, 'review 2'), (3, 'presentation'), (4, 'progress'), (5, 'other');

--
-- Data for table 'states'
--

INSERT INTO public.states (id, name) VALUES (1, 'pending'), (2, 'accepted'), (3, 'refused'), (4, 'canceled');

--
-- Constraint for table 'users'
--

ALTER TABLE ONLY public.users
	ADD CONSTRAINT users_pk PRIMARY KEY (uid),
	ADD CONSTRAINT users_unique UNIQUE (email);

--
-- Constraint for table 'disponibilities'
--

ALTER TABLE ONLY public.disponibilities
	ADD CONSTRAINT disponibilities_pk PRIMARY KEY (uid),
	ADD CONSTRAINT disponibilities_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);

--
-- Constraint for table 'groups'
--

ALTER TABLE ONLY public.groups
	ADD CONSTRAINT groups_pk PRIMARY KEY (uid);

--
-- Constraint for table 'types'
--

ALTER TABLE ONLY public.types
	ADD CONSTRAINT types_pk PRIMARY KEY (id);

--
-- Constraint for table 'reason'
--

ALTER TABLE ONLY public.reasons
	ADD CONSTRAINT reasons_pk PRIMARY KEY (id);

--
-- Constraint for table 'state'
--

ALTER TABLE ONLY public.states
	ADD CONSTRAINT states_pk PRIMARY KEY (id);

--
-- Constraint for table 'reservations'
--

ALTER TABLE ONLY public.reservations
	ADD CONSTRAINT reservations_pk PRIMARY KEY (uid),
	ADD CONSTRAINT reservations_users_fk FOREIGN KEY (uid_teacher) REFERENCES public.users(uid),
	ADD CONSTRAINT reservations_users_fk_1 FOREIGN KEY (uid_student) REFERENCES public.users(uid),
	ADD CONSTRAINT reservations_type_fk FOREIGN KEY (id_type) REFERENCES public.types(id),
	ADD CONSTRAINT reservations_reason_fk FOREIGN KEY (id_reason) REFERENCES public.reasons(id),
	ADD CONSTRAINT reservations_state_fk FOREIGN KEY (id_state) REFERENCES public.states(id);

--
-- Constraint for table 'roles'
--

ALTER TABLE ONLY public.roles
	ADD CONSTRAINT roles_pk PRIMARY KEY (id);

--
-- Constraint for table 'tutoring'
--

ALTER TABLE ONLY public.tutoring
	ADD CONSTRAINT tutoring_pk PRIMARY KEY (uid_student, uid_teacher),
	ADD CONSTRAINT tutoring_users_fk FOREIGN KEY (uid_student) REFERENCES public.users(uid),
	ADD CONSTRAINT tutoring_users_fk_1 FOREIGN KEY (uid_teacher) REFERENCES public.users(uid);

--
-- Constraint for table 'user_group'
--

ALTER TABLE ONLY public.user_group
	ADD CONSTRAINT user_group_pk PRIMARY KEY (uid_user, uid_group),
	ADD CONSTRAINT user_group_groups_fk FOREIGN KEY (uid_group) REFERENCES public.groups(uid),
	ADD CONSTRAINT user_group_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);

--
-- Constraint for table 'user_role'
--

ALTER TABLE ONLY public.user_role
	ADD CONSTRAINT user_role_pk PRIMARY KEY (uid_user, id_role),
	ADD CONSTRAINT user_role_roles_fk FOREIGN KEY (id_role) REFERENCES public.roles(id),
	ADD CONSTRAINT user_role_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);

--
-- Trigger for table 'disponibilities'
--

CREATE TRIGGER trigger_date BEFORE INSERT ON public.disponibilities FOR EACH ROW EXECUTE FUNCTION public.triggerdate();
CREATE TRIGGER trigger_date_update_disponibilities BEFORE UPDATE ON public.disponibilities FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();

--
-- Trigger for table 'users'
--

CREATE TRIGGER trigger_user AFTER INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.triggeruser();
CREATE TRIGGER trigger_date_update_users BEFORE UPDATE ON public.users FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();

--
-- Trigger for table 'reservations'
--

CREATE TRIGGER trigger_date_update_reservations BEFORE UPDATE ON public.reservations FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();
CREATE TRIGGER trigger_delete_reservation AFTER UPDATE ON public.reservations FOR EACH ROW EXECUTE FUNCTION public.triggerdeleterefused();

--
-- Trigger for table 'tutoring'
--

CREATE TRIGGER trigger_date_update_tutoring BEFORE UPDATE ON public.tutoring FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();

--
-- Trigger for table 'user_group'
--

CREATE TRIGGER trigger_date_update_user_group BEFORE UPDATE ON public.user_group FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();

--
-- Trigger for table 'user_role'
--

CREATE TRIGGER trigger_date_update_user_role BEFORE UPDATE ON public.user_role FOR EACH ROW EXECUTE FUNCTION public.triggerdateupdate();
