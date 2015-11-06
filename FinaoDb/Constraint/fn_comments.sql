ALTER TABLE `fn_comments`
  ADD CONSTRAINT `fn_comments_ibfk_1` FOREIGN KEY (`comment_author_id`) REFERENCES `fn_users` (`userid`),
  ADD CONSTRAINT `fn_comments_ibfk_2` FOREIGN KEY (`comment_author_id`) REFERENCES `fn_users` (`userid`);
