ALTER TABLE `fn_invite_friend`
  ADD CONSTRAINT `fk_inviteby_user` FOREIGN KEY (`invited_by_user_id`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fn_invite_friend_ibfk_1` FOREIGN KEY (`invited_by_user_id`) REFERENCES `fn_users` (`userid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
