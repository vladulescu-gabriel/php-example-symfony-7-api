> [!CAUTION]
> 1. Use installation guide in order to got the project working
> 2. Keep in mind that this is a test-project of symfony 7, structure may not be the best
------
> [!NOTE]
> Installation guide

* MacOS: [brew](https://brew.sh/)
* Windows: [chocolatey](https://chocolatey.org/install)

Required Software:
* docker + docker-compose (`brew install docker` / `choco install docker-desktop`)
* make (Windows: `choco install make`, it is readily available on MacOS after installing XCode)

Steps after software install:
1. Run command: make composer/install
2. Add to hosts: local.api.symfony7.com (Windows: C:\Windows\System32\drivers\etc\hosts)
3. Run command: make migration/execute
4. Run command: make project/start
------
> [!NOTE]
> Usage Guide
* SignIn and SignUp routes are public
    - SignUp requires username, email and password. User will be created with default role of **student**, and a **AuthToken** will be returned
    - SignIn requires login and password, will return a **AuthToken**
* Every other route will require **AuthToken** as "Auth Header Bearer"
* About Roles and Permissions
    - Default role will always be "student" ( can be changed from constant in Role model )
    - 3 Roles will be aded in "role db table" when command "make migration/execute" it's executed (student, teacher, director)
    - ( -- needs to to something about permissions migration )
------
> [!NOTE]
> Routes Table

* Routes Info table

| Route                                 | Method    | Required Permission                       | Requires Auth Token   |
| ------------------------------------- | --------- | ----------------------------------------- | --------------------- |
| /signin                               | POST      | NO                                        | NO                    |
| /signup                               | POST      | NO                                        | NO                    |
| /api/users                            | GET       | ACCESS_VIEW_USERS                         | YES                   |
| /api/users                            | POST      | ACCESS_ADD_USER                           | YES                   |
| /api/users/{userId}                   | GET       | ACCESS_VIEW_USER                          | YES                   |
| /api/users/{userId}/{newRole}         | PUT       | ACCESS_CHANGE_ROLE                        | YES                   |
| /api/roles                            | GET       | ACCESS_VIEW_ROLES                         | YES                   |
| /api/roles{roleId}                    | GET       | ACCESS_VIEW_ROLE                          | YES                   |
| /api/roles                            | POST      | ACCESS_ADD_ROLE                           | YES                   |
| /api/study-classes                    | GET       | ACCESS_VIEW_STUDY_CLASSES                 | YES                   |
| /api/study-classes/{studyClassId}     | GET       | ACCESS_VIEW_STUDY_CLASS                   | YES                   |
| /api/study-classes                    | POST      | ACCESS_ADD_STUDY_CLASS                    | YES                   |
| /api/study-classes/{classId}/students | POST      | ACCESS_ADD_STUDENTS_TO_STUDY_CLASS        | YES                   |
| /api/study-classes/{classId}/students | DELETE    | ACCESS_REMOVE_STUDENTS_FROM_STUDY_CLASS   | YES                   |

* Request data for routes

| Route                                 | Body Data                                                                                                     |
| ------------------------------------- | ------------------------------------------------------------------------------------------------------------- |
| /signin                               | ```json {"login": "username or email", "password": "password"} ```                                            |
| /signup                               | ```json {"email": "email@email.com", "username": "username", "password": "password"} ```                      |
| /api/users                            | NOTHING                                                                                                       |
| /api/users                            | ```json {"email": "email@email.com", "username": "username", "password": "password", "role": "roleName"} ```  |
| /api/users/{userId}                   | NOTHING                                                                                                       |
| /api/users/{userId}/{newRole}         | NOTHING                                                                                                       |
| /api/roles                            | NOTHING                                                                                                       |
| /api/roles{roleId}                    | NOTHING                                                                                                       |
| /api/roles                            | ```json {"name": "New Role Name"} ```                                                                         |
| /api/study-classes                    | NOTHING                                                                                                       |
| /api/study-classes/{studyClassId}     | NOTHING                                                                                                       |
| /api/study-classes                    | ```json {"name": "study class Name", "owner_id": "User Id with ACCESS_STUDY_CLASS_OWNER permission"} ```      |
| /api/study-classes/{classId}/students | ```json {"user_ids": [1,2,3 etc..]} ```                                                                       |
| /api/study-classes/{classId}/students | ```json {"user_ids": [1,2,3 etc..]} ```                                                                       |
