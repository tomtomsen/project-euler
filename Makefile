.PHONY: build
build: Dockerfile
	docker \
		build \
			--tag tomtomsen/project-euler:latest \
			.

.PHONY: shell
shell: build
	[ -d .phive ] || mkdir .phive
	[ -d .composer ] || mkdir .composer
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/project-euler \
			 --volume ${PWD}/.phive:/.phive \
			 --volume ${PWD}/.composer:/.composer \
			 --workdir /project-euler \
			 tomtomsen/project-euler:latest \
			 	sh

.PHONY: root-shell
root-shell: build
	docker \
		run \
			--rm \
			 -ti \
			 --user root:root \
			 --volume ${PWD}:/project-euler \
			 --workdir /project-euler \
			 tomtomsen/project-euler:latest \
			 	sh

.PHONY: check
check: build
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/project-euler \
			 --workdir /project-euler \
			 tomtomsen/project-euler:latest \
			 	./tools/grumphp run

.PHONY: cs
cs: build
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/project-euler \
			 --workdir /project-euler \
			 tomtomsen/project-euler:latest \
			 	./tools/php-cs-fixer fix .
