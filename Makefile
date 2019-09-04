.PHONY: build
build: Dockerfile
	docker \
		build \
			--tag tomtomsen/project-euler:latest \
			.

.PHONY: shell
shell: build
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/data \
			 --workdir /data \
			 tomtomsen/project-euler:latest \
			 	sh

.PHONY: sudo-shell
sudo-shell: build
	docker \
		run \
			--rm \
			 -ti \
			 --user root:root \
			 --volume ${PWD}:/data \
			 --workdir /data \
			 tomtomsen/project-euler:latest \
			 	sh

.PHONY: check
check: build
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/data \
			 --workdir /data \
			 tomtomsen/project-euler:latest \
			 	./tools/grumphp run

.PHONY: cs
cs: build
	docker \
		run \
			--rm \
			 -ti \
			 --user `id -u`:`id -g` \
			 --volume ${PWD}:/data \
			 --workdir /data \
			 tomtomsen/project-euler:latest \
			 	./tools/php-cs-fixer fix .
