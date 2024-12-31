--
-- Trigger triggerdate()
--

CREATE OR REPLACE FUNCTION public.triggerdate() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
	if (select (old.date_start, old.date_end) overlaps (new.date_start, new.date_end)) then
		return old;
	end if;
	return new;
end; $$;

--
-- Trigger triggeruser()
--

CREATE OR REPLACE FUNCTION public.triggeruser() RETURNS trigger
	LANGUAGE PLPGSQL
	AS $$
BEGIN
    INSERT INTO user_role (uid_user) VALUES (NEW.uid);
    RETURN NEW;
END; $$;

--
-- Table structure for table 'disponibilities'
--

CREATE TABLE public.disponibilities (
    uid character varying(32) NOT NULL,
    uid_user character varying(32) NOT NULL,
    date_start date DEFAULT CURRENT_TIMESTAMP NOT NULL,
    date_end date DEFAULT CURRENT_TIMESTAMP NOT NULL,
    type integer DEFAULT 1 NOT NULL,
    reason integer DEFAULT 1 NOT NULL,
    state integer NOT NULL
);

--
-- Table structure for table 'groups'
--

CREATE TABLE public.groups (
    uid character varying(32) NOT NULL
);

--
-- Table structure for table 'reservations'
--

CREATE TABLE public.reservations (
    uid_teacher character varying(32) NOT NULL,
    uid_student character varying(32) NOT NULL,
    uid_disponibilities character varying(32) NOT NULL
);

--
-- Table structure for table 'roles'
--

CREATE TABLE public.roles (
    id integer NOT NULL,
	name character varying(32) NOT NULL
);

--
-- Table structure for table 'tutoring'
--

CREATE TABLE public.tutoring (
    uid_student character varying(32) NOT NULL,
    uid_teacher character varying(32) NOT NULL
);

--
-- Table structure for table 'users'
--

CREATE TABLE public.users (
    uid character varying(32) NOT NULL,
    email character varying(255) NOT NULL
);

--
-- Table structure for table 'user_group'
--

CREATE TABLE public.user_group (
    uid_user character varying(32) NOT NULL,
    uid_group character varying(32) NOT NULL
);

--
-- Table structure for table 'user_role'
--

CREATE TABLE public.user_role (
    uid_user character varying(32) NOT NULL,
    id_role integer NOT NULL DEFAULT 1
);

--
-- Data for table 'roles'
--

INSERT INTO public.roles (id, name) VALUES (1, 'student'), (2, 'teacher'), (10, 'adminstrator');

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
-- Constraint for table 'reservations'
--

ALTER TABLE ONLY public.reservations
    ADD CONSTRAINT reservations_pk PRIMARY KEY (uid_teacher, uid_student, uid_disponibilities),
    ADD CONSTRAINT reservations_disponibilities_fk FOREIGN KEY (uid_disponibilities) REFERENCES public.disponibilities(uid),
    ADD CONSTRAINT reservations_users_fk FOREIGN KEY (uid_teacher) REFERENCES public.users(uid),
    ADD CONSTRAINT reservations_users_fk_1 FOREIGN KEY (uid_student) REFERENCES public.users(uid);

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

--
-- Trigger for table 'users'
--

create trigger trigger_user AFTER INSERT ON public.users FOR EACH ROW EXECUTE FUNCTION public.triggeruser();
