CREATE TABLE public.users
(
    id uuid NOT NULL,
    login text NOT NULL,
    password text NOT NULL,
    firstname text NOT NULL,
    lastname text NOT NULL,
    age smallint NOT NULL,
    email text NOT NULL,
    phone text,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.users
    OWNER to postgres;