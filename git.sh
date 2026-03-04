#!/usr/bin/env bash
git filter-branch -f --env-filter '

export GIT_AUTHOR_NAME="Harshvardhan2212"
export GIT_AUTHOR_EMAIL="harshvardhan.z2002@gmail.com"
export GIT_COMMITTER_NAME="Harshvardhan2212"
export GIT_COMMITTER_EMAIL="harshvardhan.z2002@gmail.com"

' --tag-name-filter cat -- --branches --tags
