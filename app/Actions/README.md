# Actions

One action represents one application use case, such as `CreateRoleAction` or `LoginAction`.

Controllers call actions. Actions may coordinate services, models, jobs, and transactions.
Do not put HTTP request parsing or response formatting here.
