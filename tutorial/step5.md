# Step 5

**[Prev: Step 4, Contact list](./step4.md)**


This step adds a backoffice module to the application in order to edit companies and users. Two pages, `backoffice/company` and `backoffice/user` enable users to edit, add and delete companies and users.

Administrators have access to both of them whereas managers can only access the latest. Simple users don't have access to the backoffice at all.

Moreover, managers only have the right to edit and add users belonging to the companies they belong to themselves.

To simplify access control, the Authentication service has been extended so we could add a method checking whether a user can edit another user entity.


**[Prev: Step 4, Contact list](./step4.md)**
