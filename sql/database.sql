--
-- Name: triggerdate(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION public.triggerdate() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
begin
	if (select (old.date_start, old.date_end) overlaps (new.date_start, new.date_end)) then
		return old;
	end if;
	return new;
end; $$;

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
    id integer NOT NULL
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
-- Table structure for table 'users_groups'
--

CREATE TABLE public.users_groups (
    uid_user character varying(32) NOT NULL,
    uid_group character varying(32) NOT NULL
);

--
-- Table structure for table 'users_roles'
--

CREATE TABLE public.users_roles (
    uid_user character varying(32) NOT NULL,
    id_role integer NOT NULL
);

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
-- Constraint for table 'users_groups'
--

ALTER TABLE ONLY public.users_groups
    ADD CONSTRAINT users_groups_pk PRIMARY KEY (uid_user, uid_group),
    ADD CONSTRAINT users_groups_groups_fk FOREIGN KEY (uid_group) REFERENCES public.groups(uid),
    ADD CONSTRAINT users_groups_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);

--
-- Constraint for table 'users'
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pk PRIMARY KEY (uid),
    ADD CONSTRAINT users_unique UNIQUE (email);

--
-- Constraint for table 'users_roles'
--

ALTER TABLE ONLY public.users_roles
    ADD CONSTRAINT users_roles_pk PRIMARY KEY (uid_user, id_role),
    ADD CONSTRAINT users_roles_roles_fk FOREIGN KEY (id_role) REFERENCES public.roles(id),
    ADD CONSTRAINT users_roles_users_fk FOREIGN KEY (uid_user) REFERENCES public.users(uid);

--
-- Trigger for table 'disponibilities'
--

CREATE TRIGGER trigger1 BEFORE INSERT ON public.disponibilities FOR EACH ROW EXECUTE FUNCTION public.triggerdate();
